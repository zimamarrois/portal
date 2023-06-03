<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use App\Models\Pendaftaran;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class PendaftarTerbaru extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Pendaftaran::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('nama_count')->counts('nama'),
            Tables\Columns\TextColumn::make('nama')
            ->label('Nama'),
            Tables\Columns\TextColumn::make('kantor.kantor')
            ->label('Kantor Cabang'),
            Tables\Columns\TextColumn::make('created_at')->date()
            ->label('Tanggal daftar'),
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
