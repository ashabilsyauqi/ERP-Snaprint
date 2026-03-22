<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function add($materialId, $branchId, $qty, $reference = null)
    {
        DB::transaction(function () use ($materialId, $branchId, $qty, $reference) {

            $stock = Stock::where('material_id', $materialId)
                ->where('branch_id', $branchId)
                ->lockForUpdate()
                ->first();

            if (!$stock) {
                $stock = Stock::create([
                    'material_id' => $materialId,
                    'branch_id' => $branchId,
                    'qty' => 0
                ]);
            }

            $before = $stock->qty;
            $after = $before + $qty;

            $stock->update(['qty' => $after]);

            StockLog::create([
                'material_id' => $materialId,
                'branch_id' => $branchId,
                'qty_change' => $qty,
                'qty_before' => $before,
                'qty_after' => $after,
                'type' => 'IN',
                'reference_type' => $reference['type'] ?? null,
                'reference_id' => $reference['id'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });
    }

    public function reduce($materialId, $branchId, $qty, $reference = null)
    {
        DB::transaction(function () use ($materialId, $branchId, $qty, $reference) {

            $stock = Stock::where('material_id', $materialId)
                ->where('branch_id', $branchId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($stock->qty < $qty) {
                throw new \Exception("Stock tidak cukup");
            }

            $before = $stock->qty;
            $after = $before - $qty;

            $stock->update(['qty' => $after]);

            StockLog::create([
                'material_id' => $materialId,
                'branch_id' => $branchId,
                'qty_change' => -$qty,
                'qty_before' => $before,
                'qty_after' => $after,
                'type' => 'OUT',
                'reference_type' => $reference['type'] ?? null,
                'reference_id' => $reference['id'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });
    }
}
