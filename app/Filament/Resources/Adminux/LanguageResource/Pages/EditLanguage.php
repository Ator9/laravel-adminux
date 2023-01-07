<?php

namespace App\Filament\Resources\Adminux\LanguageResource\Pages;

use App\Filament\Resources\Adminux\LanguageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
