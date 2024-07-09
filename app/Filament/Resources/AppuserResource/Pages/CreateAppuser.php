<?php

namespace App\Filament\Resources\AppuserResource\Pages;

use App\Filament\Resources\AppuserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppuser extends CreateRecord
{
    protected static string $resource = AppuserResource::class;
    protected static bool $canCreateAnother = false;
}
