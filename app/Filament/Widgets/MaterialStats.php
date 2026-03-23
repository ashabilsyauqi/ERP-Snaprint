<?php

namespace App\Filament\Widgets;


use App\Models\Material;
// use App\Models\Stock;
use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\TableWidget;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MaterialStats extends TableWidget
{
    protected static ?string $heading = 'Material Overview';


    protected function getTableQuery(): Builder
    {
        return Material::query()->latest();
    }
    
    public function getTableRecordsPerPage(): int
    {
        return 3;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Material'),

            Tables\Columns\TextColumn::make('unit')
                ->label('Unit'),

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