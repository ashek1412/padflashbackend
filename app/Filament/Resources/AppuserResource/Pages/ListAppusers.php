<?php

namespace App\Filament\Resources\AppuserResource\Pages;

use App\Filament\Resources\AppuserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppusers extends ListRecords
{
    protected static string $resource = AppuserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
