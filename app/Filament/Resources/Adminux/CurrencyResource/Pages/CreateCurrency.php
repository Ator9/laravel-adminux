<?php

namespace App\Filament\Resources\Adminux\CurrencyResource\Pages;

use App\Filament\Resources\Adminux\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    protected static string $resource = CurrencyResource::class;
}
