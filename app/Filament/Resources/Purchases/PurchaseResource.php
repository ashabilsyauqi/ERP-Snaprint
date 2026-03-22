<?php

namespace App\Filament\Resources\Purchases;

use App\Models\Purchase;
use App\Models\Material;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\Purchases\Pages\ListPurchases;
use App\Filament\Resources\Purchases\Pages\CreatePurchase;
use App\Filament\Resources\Purchases\Pages\EditPurchase;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $navigationLabel = 'Purchases';

    protected static ?string $recordTitleAttribute = 'id';

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Forms\Components\TextInput::make('branch_id')
                ->label('Branch')
                ->default(1)
                ->required(),

            Forms\Components\Repeater::make('items')
                ->label('Items')
                ->schema([

                    Forms\Components\Select::make('material_id')
                        ->label('Material')
                        ->options(fn () => Material::pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\TextInput::make('qty')
                        ->label('Quantity')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('price')
                        ->label('Price')
                        ->numeric()
                        ->required(),

                ])
                ->required()
                ->minItems(1)
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('ID'),
            Tables\Columns\TextColumn::make('total_amount')->label('Total'),
            Tables\Columns\TextColumn::make('status')->label('Status'),
            Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPurchases::route('/'),
            'create' => CreatePurchase::route('/create'),
            'edit' => EditPurchase::route('/{record}/edit'),
        ];
    }
}