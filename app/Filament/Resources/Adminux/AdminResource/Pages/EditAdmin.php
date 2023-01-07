<?php

namespace App\Filament\Resources\Adminux\AdminResource\Pages;

use App\Filament\Resources\Adminux\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // if(!empty($data['password'])) $data['password'] = \Hash::make($data['password']);

        return $data;
    }
}
