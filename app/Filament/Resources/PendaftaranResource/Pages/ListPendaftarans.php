<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Filament\Resources\PendaftaranResource\Widgets\PendaftaranStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftarans extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PendaftaranStatsOverview::class,
        ];
    }
    protected function getDefaultTableSortColumn(): ?string
    {
    return 'created_at';
    }
    protected function getDefaultTableSortDirection(): ?string
    {
    return 'desc';
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [6, 25, 50, 100];

    }
        
}
