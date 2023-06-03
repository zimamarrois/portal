<?php

namespace App\Filament\Resources\MasukResource\Pages;

use App\Filament\Resources\MasukResource;
use App\Filament\Resources\MasukResource\Widgets\NominalMasukOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasuks extends ListRecords
{
    protected static string $resource = MasukResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            NominalMasukOverview::class
        ];
    }
}
