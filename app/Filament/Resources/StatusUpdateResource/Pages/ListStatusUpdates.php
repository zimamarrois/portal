<?php

namespace App\Filament\Resources\StatusUpdateResource\Pages;

use App\Filament\Resources\StatusUpdateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusUpdates extends ListRecords
{
    protected static string $resource = StatusUpdateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
