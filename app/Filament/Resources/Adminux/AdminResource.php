<?php

namespace App\Filament\Resources\Adminux;

use App\Filament\Resources\Adminux\AdminResource\Pages;
use App\Filament\Resources\Adminux\AdminResource\RelationManagers;
use App\Adminux\Admin\Models\Admin;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use App\Adminux\Admin\Models\Language;

// php artisan make:filament-resource Adminux/Admin --view
class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-s-cog';

    protected static ?string $slug = 'adminux/admins';
    protected static ?string $navigationGroup = 'Superuser';
    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')->password()->autocomplete('new-password')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\Select::make('language_id')->label('Language')->options(Language::all()->pluck('language', 'id'))->default('1')->disablePlaceholderSelection(),
                Forms\Components\Select::make('active')->options([
                    'Y' => 'Activo',
                    'N' => 'Inactivo',
                ])->default('Y')->disablePlaceholderSelection()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    // php artisan make:filament-relation-manager Adminux/AdminResource language language_id
    public static function getRelations(): array
    {
        return [
            // RelationManagers\LanguageRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
