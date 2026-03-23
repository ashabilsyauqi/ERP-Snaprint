<?php
namespace App\Filament\Resources\Stocks;

use App\Models\Stock;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    // protected static $navigationIcon = Heroicon::OutlinedCube;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([

            Tables\Columns\TextColumn::make('material.name')
                ->label('Material'),

            Tables\Columns\TextColumn::make('qty')
                ->label('Stock'),

            Tables\Columns\TextColumn::make('branch_id')
                ->label('Branch'),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated')
                ->dateTime(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
        ];
    }


    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
}   


