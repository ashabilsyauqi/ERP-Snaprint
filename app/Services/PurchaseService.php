<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1. Create Purchase (draft dulu)
            $purchase = Purchase::create([
                'branch_id' => $data['branch_id'],
                'created_by' => auth()->id(),
                'total_amount' => 0,
                'status' => 'completed', // langsung completed (biar langsung masuk stock)
            ]);

            $total = 0;

            // 2. Loop items
            foreach ($data['items'] as $item) {

                $qty = $item['qty'];
                $price = $item['price'];
                $subtotal = $qty * $price;

                // 3. Save item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'material_id' => $item['material_id'],
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // 4. Tambah stock
                $this->stockService->add(
                    $item['material_id'],
                    $data['branch_id'],
                    $qty,
                    [
                        'type' => 'purchase',
                        'id' => $purchase->id
                    ]
                );

                $total += $subtotal;
            }

            // 5. Update total
            $purchase->update([
                'total_amount' => $total
            ]);

            return $purchase;
        });
    }
}
