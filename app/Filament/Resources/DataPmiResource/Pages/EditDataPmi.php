<?php

namespace App\Filament\Resources\DataPmiResource\Pages;

use App\Filament\Resources\DataPmiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPmi extends EditRecord
{
    protected static string $resource = DataPmiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
