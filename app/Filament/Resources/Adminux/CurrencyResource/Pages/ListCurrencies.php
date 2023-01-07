<?php

namespace App\Filament\Resources\Adminux\CurrencyResource\Pages;

use App\Filament\Resources\Adminux\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
