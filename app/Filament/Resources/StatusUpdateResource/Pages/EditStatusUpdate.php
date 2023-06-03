<?php

namespace App\Filament\Resources\StatusUpdateResource\Pages;

use App\Filament\Resources\StatusUpdateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusUpdate extends EditRecord
{
    protected static string $resource = StatusUpdateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
