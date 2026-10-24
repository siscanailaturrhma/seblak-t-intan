<?php

namespace App\Filament\Resources\Toppings\Pages;

use App\Filament\Resources\Toppings\ToppingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListToppings extends ListRecords
{
    protected static string $resource = ToppingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
