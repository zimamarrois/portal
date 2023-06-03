<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\DataPmi;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

class UpdateStatusTerbaru extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return DataPmi::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('Pendaftaran.nama')
            ->label('Nama'),
            Tables\Columns\TextColumn::make('StatusUpdate.status_update')
            ->label('Status'),
            Tables\Columns\TextColumn::make('updated_at')->date()
            ->label('Tanggal Update'),
        ];
    }
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate($this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage());
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 25, 50, 100];

    }
}
