<?php

namespace App\Filament\Resources\Adminux\CurrencyResource\Pages;

use App\Filament\Resources\Adminux\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{
    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
