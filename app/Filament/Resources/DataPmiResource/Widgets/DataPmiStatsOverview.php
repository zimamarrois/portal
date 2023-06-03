<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\DataPmi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class DataPmiStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        
        $NONJOB = DataPmi::where('job','0')->count();
        $JOB = DataPmi::where('job','1')->count();
        $PMIFinish = DataPmi::where('status_update_id','18')->count();
        $PMIMD = DataPmi::where('status_update_id','19')->count();
        $PMIPending = DataPmi::where('status_update_id','21')->count();
        $UNFIT = DataPmi::where('fit','0')->count();
        $DATAPMI = DataPmi::all()->count();
        $TERBANG = DataPmi::where('status_update_id','15')->count();

        $DIPROSES = $DATAPMI - $PMIMD - $PMIPending - $UNFIT - $TERBANG - $PMIFinish;
        $TotalJob = $DATAPMI - $JOB- $PMIMD - $PMIPending - $UNFIT - $TERBANG - $PMIFinish;
        // $TotalJob = $JOB - $PMIMD - $PMIPending - $UNFIT - $TERBANG - $PMIFinish;
        $TotalNonJob = $DATAPMI - $NONJOB;
        


        return [
            // Card::make('DATA PMI', DataPmi::all()->count())
            // ->description('Total Data PMI')
            // ->descriptionIcon('heroicon-o-check-circle')
            // ->color('success'),

            Card::make('DIPROSES',($DIPROSES))
            ->description('Diproses')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            Card::make('JOB',($TotalJob))
            ->description('Sudah Dapat Job')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success'),

            Card::make('NON JOB',($TotalNonJob))
            ->description('Belum Dapat Job')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('danger'),
            
        ];
    }
}
