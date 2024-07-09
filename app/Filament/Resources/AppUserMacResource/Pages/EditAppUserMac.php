<?php

namespace App\Filament\Resources\AppUserMacResource\Pages;

use App\Filament\Resources\AppUserMacResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppUserMac extends EditRecord
{
    protected static string $resource = AppUserMacResource::class;



    protected function getHeaderActions(): array
    {
        return [
          //  Actions\DeleteAction::make(),
        ];
    }
}
