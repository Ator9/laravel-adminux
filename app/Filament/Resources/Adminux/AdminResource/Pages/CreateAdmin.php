<?php

namespace App\Filament\Resources\Adminux\AdminResource\Pages;

use App\Filament\Resources\Adminux\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $data['password'] = Hash::make($data['password']);

        // dd($data);

        return $data;
    }
}
