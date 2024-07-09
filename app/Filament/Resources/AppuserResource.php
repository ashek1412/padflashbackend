<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppuserResource\Pages;
use App\Filament\Resources\AppuserResource\RelationManagers\MachinesRelationManager;
use App\Models\AppUser;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Laravel\Prompts\text;

class AppuserResource extends Resource
{
    protected static ?string $model = Appuser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Padflash Users';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              TextInput::make('email')->required('')->email(),
              TextInput::make('machine_id')->required(''),
              TextInput::make('sl_num')->required(''),
              TextInput::make('fw_num'),
              Toggle::make('active')->required()->onColor('success')
                  ->offColor('danger'),
              DateTimePicker::make('varified_at') ->native(false),
              DatePicker::make('expiry_date')->format('Y-m-d')->required() ->native(false),
              DateTimePicker::make('created_at')->disabled()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->size(TextColumnSize::ExtraSmall),
                TextColumn::make('machine_id')->size(TextColumnSize::ExtraSmall),
                TextColumn::make('sl_num')->size(TextColumnSize::ExtraSmall),
                ToggleColumn::make('active')->disabled(),
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
                  //  Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MachinesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppusers::route('/'),
            'create' => Pages\CreateAppuser::route('/create'),
            'edit' => Pages\EditAppuser::route('/{record}/edit'),
        ];
    }
}
