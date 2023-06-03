<?php

namespace App\Filament\Resources\PengalamanResource\Pages;

use App\Filament\Resources\PengalamanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengalaman extends EditRecord
{
    protected static string $resource = PengalamanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
