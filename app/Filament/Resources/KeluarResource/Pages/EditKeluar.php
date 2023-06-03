<?php

namespace App\Filament\Resources\KeluarResource\Pages;

use App\Filament\Resources\KeluarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeluar extends EditRecord
{
    protected static string $resource = KeluarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
