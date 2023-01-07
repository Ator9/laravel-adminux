<?php

namespace App\Filament\Pages\Adminux;

use Filament\Pages\Page;
use Filament\Pages\Actions\Action;

// php artisan make:filament-page Adminux/Composer
class Composer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'adminux.filament.pages.adminux.composer';

    protected static ?string $slug = 'adminux/composer';
    protected static ?string $navigationGroup = 'Superuser';
    protected static ?int $navigationSort = 102;
}
