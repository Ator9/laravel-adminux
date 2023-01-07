<?php

namespace App\Filament\Pages\Adminux;

use Filament\Pages\Page;
use Filament\Pages\Actions\Action;

// php artisan make:filament-page Adminux/Logs
class Logs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'adminux.filament.pages.adminux.logs';

    protected static ?string $slug = 'adminux/logs';
    protected static ?string $navigationGroup = 'Superuser';
    protected static ?int $navigationSort = 101;

    // config/logging.php: 'channels' => ['daily']
    // 'permission' => 0666, // to avoid logs writted by root and then user cant overwrite. 500 error
    protected function getViewData(): array
    {
        $file = storage_path().'/logs/laravel-'.date('Y-m-d').'.log';

        return [ 'body' => \File::exists($file) ? nl2br(\File::get($file)) : 'No errors today :)' ];
    }

    protected function getActions(): array
    {
        return [ Action::make('delete')->action('deleteLogs') ];
    }

    public function deleteLogs(): void
    {
        $file = storage_path().'/logs/laravel-'.date('Y-m-d').'.log';
        \File::delete($file);
    }
}
