<?php

namespace App\Filament\Resources\Adminux\CurrencyResource\Pages;

use App\Filament\Resources\Adminux\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCurrency extends ViewRecord
{
    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
