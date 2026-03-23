<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\TableWidget;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;


class StockStats extends TableWidget
{
    protected static ?string $heading = 'Stock Overview';


    protected function getTableQuery(): Builder
    {
        return Stock::query()->latest();
    }
    
    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('material.name')
                ->label('Material'),

            Tables\Columns\TextColumn::make('qty')
                ->label('Stock'),

            Tables\Columns\TextColumn::make('updated_at')
                ->since(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('view_all')
                ->label('Lihat Semua')
                ->url('/admin/stocks')
                ->icon('heroicon-o-arrow-right'),
        ];
    }
}