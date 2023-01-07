<?php

namespace App\Filament\Resources\Adminux\AdminResource\Pages;

use App\Filament\Resources\Adminux\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
