<?php

namespace App\Filament\Resources\PetugasLapanganResource\Pages;

use App\Filament\Resources\PetugasLapanganResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPetugasLapangans extends ListRecords
{
    protected static string $resource = PetugasLapanganResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
