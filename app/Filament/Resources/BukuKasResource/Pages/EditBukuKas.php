<?php

namespace App\Filament\Resources\BukuKasResource\Pages;

use App\Filament\Resources\BukuKasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBukuKas extends EditRecord
{
    protected static string $resource = BukuKasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
