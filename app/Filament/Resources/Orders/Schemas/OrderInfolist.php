<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data pelanggan')
                    ->schema([
                        TextEntry::make('customer_name')
                            ->label('Nama'),
                        TextEntry::make('customer_phone')
                            ->label('No. WhatsApp'),
                        TextEntry::make('total_price')
                            ->label('Total harga')
                            ->money('IDR', locale: 'id'),
                        TextEntry::make('created_at')
                            ->label('Waktu pesan')
                            ->dateTime('d M Y, H:i'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Rincian pesanan')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('menu_name')
                                    ->label('Menu'),
                                TextEntry::make('quantity')
                                    ->label('Jumlah'),
                                TextEntry::make('price')
                                    ->label('Harga menu')
                                    ->money('IDR', locale: 'id'),
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('IDR', locale: 'id'),
                                TextEntry::make('selection_summary')
                                    ->label('Pilihan')
                                    ->state(function ($record) {
                                        $selections = $record->selections ?? [];

                                        if (! empty($selections)) {
                                            return collect($selections)
                                                ->groupBy('group')
                                                ->map(fn ($items, $group) => $group . ': ' . $items
                                                    ->map(fn ($s) => $s['name'] . ($s['quantity'] > 1 ? ' x' . $s['quantity'] : ''))
                                                    ->implode(', '))
                                                ->implode(' | ');
                                        }

                                        $parts = [];

                                        if ($record->spice_level) {
                                            $parts[] = 'Level pedas: ' . $record->spice_level;
                                        }

                                        if ($record->toppings->isNotEmpty()) {
                                            $parts[] = 'Topping: ' . $record->toppings
                                                ->map(fn ($t) => $t->topping_name . ' x' . ($t->quantity ?? 1))
                                                ->implode(', ');
                                        }

                                        return $parts ? implode(' | ', $parts) : 'Tanpa pilihan';
                                    })
                                    ->columnSpanFull(),
                            ])
                            ->columns(4),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}