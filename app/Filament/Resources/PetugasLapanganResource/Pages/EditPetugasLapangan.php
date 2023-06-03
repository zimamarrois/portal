<?php

namespace App\Filament\Resources\PetugasLapanganResource\Pages;

use App\Filament\Resources\PetugasLapanganResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPetugasLapangan extends EditRecord
{
    protected static string $resource = PetugasLapanganResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
