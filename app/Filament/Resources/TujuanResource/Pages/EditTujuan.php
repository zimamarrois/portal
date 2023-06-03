<?php

namespace App\Filament\Resources\TujuanResource\Pages;

use App\Filament\Resources\TujuanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTujuan extends EditRecord
{
    protected static string $resource = TujuanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
