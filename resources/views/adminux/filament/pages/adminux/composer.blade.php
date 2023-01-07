<x-filament::page>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">Information | Laravel @php echo app()->version() @endphp</div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item">Env: @php echo env('APP_ENV') @endphp</li>
                <li class="list-group-item">Cache: @php echo env('CACHE_DRIVER') @endphp</li>
            </ul>
            <div class="mb-3">
                <button class="mfilament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" onclick="document.getElementById('run').src = '{{ url('adminux/admins_composer?command=composer_install') }}'">
                    composer install
                </button>
                <button class="mfilament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" onclick="document.getElementById('run').src = '{{ url('adminux/admins_composer?command=config_clear') }}'">
                    cache:clear | config:clear
                </button>
                <button class="mfilament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" onclick="document.getElementById('run').src = '{{ url('adminux/admins_composer?command=config_cache') }}'">
                    php artisan config:cache
                </button>
            </div>
        </div>
    </div>
    <iframe id="run" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>
</div>
</x-filament::page>
