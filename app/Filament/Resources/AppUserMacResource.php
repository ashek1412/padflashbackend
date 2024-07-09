<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppUserMacResource\Pages;
use App\Models\AppUserMac;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppUserMacResource extends Resource
{
    protected static ?string $model = AppUserMac::class;

    protected static ?string $navigationLabel = 'User Machines';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function canCreate(): bool
    {
        return false;
    }





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_email')->disabled(),
                TextInput::make('machine_id')->disabled(),
                Forms\Components\DateTimePicker::make('created_at')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_email')->size(TextColumnSize::ExtraSmall),
                TextColumn::make('machine_id')->size(TextColumnSize::ExtraSmall),
                TextColumn::make('created_at')->size(TextColumnSize::ExtraSmall),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppUserMacs::route('/'),
            'create' => Pages\CreateAppUserMac::route('/create'),
            'edit' => Pages\EditAppUserMac::route('/{record}/edit'),
        ];
    }
}
