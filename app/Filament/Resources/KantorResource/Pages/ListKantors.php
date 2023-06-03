<?php

namespace App\Filament\Resources\KantorResource\Pages;

use App\Filament\Resources\KantorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKantors extends ListRecords
{
    protected static string $resource = KantorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
