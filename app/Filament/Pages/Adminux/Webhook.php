<?php

namespace App\Filament\Pages\Adminux;

use Filament\Pages\Page;

// php artisan make:filament-page Adminux/Webhook
class Webhook extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'adminux.filament.pages.adminux.webhook';

    protected static ?string $slug = 'adminux/webhook';
    protected static ?string $navigationGroup = 'Superuser';
    protected static ?int $navigationSort = 101;
}
