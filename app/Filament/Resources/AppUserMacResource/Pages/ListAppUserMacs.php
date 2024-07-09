<?php

namespace App\Filament\Resources\AppUserMacResource\Pages;

use App\Filament\Resources\AppUserMacResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppUserMacs extends ListRecords
{
    protected static string $resource = AppUserMacResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
