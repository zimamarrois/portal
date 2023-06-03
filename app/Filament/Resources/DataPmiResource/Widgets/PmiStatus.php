<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\DataPmi;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PmiStatus extends BaseWidget
{
    protected function getCards(): array
    {
        $jumlahDataPmi = DataPmi::all()->count();
        $PMIFinish = DataPmi::where('status_update_id','18')->count();
        $PMIMD = DataPmi::where('status_update_id','19')->count();
        $PMIPending = DataPmi::where('status_update_id','21')->count();
        $TERBANG = DataPmi::where('status_update_id','15')->count();
        $UNFIT = DataPmi::where('fit','0')->count();
        $TERDAFTARSIAPKERJA = DataPmi::where('siapkerja','1')->count();
        

        $stockPMI = $jumlahDataPmi - $PMIMD - $PMIPending - $UNFIT - $PMIFinish - $TERBANG;
        return [

            Card::make('PMI MD',($PMIMD))
            ->description('PMI Mengundurkan Diri')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('danger'),

            Card::make('PMI PENDING',($PMIPending))
            ->description('PMI Pending')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('warning'),

            Card::make('PMI FINISH',($PMIFinish))
            ->description('Total PMI Finish')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            
        ];
    }
}
