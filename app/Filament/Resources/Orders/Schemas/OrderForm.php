<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->label('Nama pembeli')
                    ->required()
                    ->maxLength(255),
                TextInput::make('customer_phone')
                    ->label('No. WhatsApp')
                    ->tel()
                    ->required()
                    ->maxLength(30),
                TextInput::make('total_price')
                    ->label('Total harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0),
            ]);
    }
}