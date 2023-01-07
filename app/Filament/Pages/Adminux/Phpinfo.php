<?php

namespace App\Filament\Pages\Adminux;

use Filament\Pages\Page;

// php artisan make:filament-page Adminux/Logs
class Phpinfo extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'adminux.filament.pages.adminux.phpinfo';

    protected static ?string $navigationLabel  = 'PHP Info';
    protected static ?string $title  = 'PHP Info';
    protected static ?string $slug = 'adminux/phpinfo';
    protected static ?string $navigationGroup = 'Superuser';
    protected static ?int $navigationSort = 101;
}
