<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\DataPmi;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SiapKerjaOverview extends BaseWidget
{
    protected function getCards(): array
    {
        
        $TERDAFTARSIAPKERJA = DataPmi::where('siapkerja','1')->count();
        $VERDATA = DataPmi::where('verdata','1')->count();
        $VERPP = DataPmi::where('verpp','1')->count();
        

        return [
            
            Card::make('SIAP KERJA',($TERDAFTARSIAPKERJA))
            ->description('Terdaftar SiapKerja')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            Card::make('VERIFIKASI SIAPKERJA',($VERDATA))
            ->description('Terverifikasi SiapKerja')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            Card::make('ID CPMI',($VERPP))
            ->description('ID Terverifikasi SiapKerja')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),
        ];
    }
}
