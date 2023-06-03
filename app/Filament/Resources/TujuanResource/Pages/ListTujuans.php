<?php

namespace App\Filament\Resources\TujuanResource\Pages;

use App\Filament\Resources\TujuanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTujuans extends ListRecords
{
    protected static string $resource = TujuanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
