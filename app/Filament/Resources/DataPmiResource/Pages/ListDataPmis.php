<?php
namespace App\Filament\Resources\DataPmiResource\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\DataPmiResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\ButtonAction;
use App\Exports\DataPmisExport;
use App\Filament\Resources\DataPmiResource\Widgets\DataPmiOverview;
use App\Filament\Resources\DataPmiResource\Widgets\SiapKerjaOverview;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DataPmi;
use Filament\Forms;

class ListDataPmis extends ListRecords
{
    protected static string $resource = DataPmiResource::class;

    protected function getDefaultTableSortColumn(): ?string
    {
    return 'created_at';
    }
    protected function getDefaultTableSortDirection(): ?string
    {
    return 'desc';
    }
    protected function getHeaderWidgets(): array
    {
        return [
            DataPmiOverview::class,
            SiapKerjaOverview::class,
            // FilamentExportHeaderAction::make('export')
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [9, 25, 50, 100, 1000];

    }
    
}
