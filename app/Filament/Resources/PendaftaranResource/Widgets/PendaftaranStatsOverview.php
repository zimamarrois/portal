<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use App\Models\DataPmi;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PendaftaranStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        
        return [

            Card::make('PENDAFTARAN', Pendaftaran::all()->count())
            ->description('Total Pendaftar')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            Card::make('DATA PMI', DataPmi::all()->count())
            ->description('Total Data PMI')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success'),
            
        ];
    }
}
