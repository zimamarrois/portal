<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\DataPmi;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class WeleriOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $DATAPMI = DataPmi::where('kantor_id', '4')->count();
        $MEDICAL = DataPmi::where('kantor_id', '4')->where('medical_check','1')->count();
        
        $NONJOB = DataPmi::where('kantor_id', '4')->where('job','0')->count();
        $JOB = DataPmi::where('kantor_id', '4')->where('job','1')->count();
        
        $PMIFINISH = DataPmi::where('kantor_id', '4')->where('status_update_id','18')->count();
        $PMIMD = DataPmi::where('kantor_id', '4')->where('status_update_id','19')->count();
        $PMIPENDING = DataPmi::where('kantor_id', '4')->where('status_update_id','21')->count();
        $FIT = DataPmi::where('kantor_id', '4')->where('fit','1')->count();
        $UNFIT = DataPmi::where('kantor_id', '4')->where('fit','0')->count();
        $TERBANG = DataPmi::where('kantor_id', '4')->where('status_update_id','15')->count();
        
        $TERDAFTARSIAPKERJA = DataPmi::where('kantor_id', '4')->where('siapkerja','1')->count();
        $VERDATA = DataPmi::where('kantor_id', '4')->where('verdata','1')->count();
        $VERPP = DataPmi::where('kantor_id', '4')->where('verpp','1')->count();

        $DIPROSES = $DATAPMI - $PMIMD - $PMIPENDING - $UNFIT - $TERBANG - $PMIFINISH;
        $TOTALJOB = $JOB - $TERBANG - $PMIFINISH;
        $TOTALNONJOB = $NONJOB - $PMIMD - $PMIPENDING;

        $TOTALSIAPKERJA = $TERDAFTARSIAPKERJA;
        $TOTALVERDATA = $VERDATA;
        $TOTALVERPP = $VERPP;
        
        $TOTALMEDICAL = $FIT - $PMIMD - $PMIPENDING - $TERBANG - $PMIFINISH;
        


        return [
            Card::make('MEDICAL',($TOTALMEDICAL))
            ->description('Total Medical')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success')
            ->chart([7, 2, 25, 3, 15, 70, 45]),

            Card::make('DIPROSES',($DIPROSES))
            ->description('Diproses')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success')
            ->chart([7, 2, 40, 70, 15, 76, 17]),

            Card::make('JOB',($TOTALJOB))
            ->description('Sudah Dapat Job')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success')
            ->chart([7, 2, 58, 3, 15, 4, 17]),

            Card::make('NON JOB',($TOTALNONJOB))
            ->description('Belum Dapat Job')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('danger')
            ->chart([12, 2, 20, 3, 70, 4, 34]),

            // Card::make('SIAP KERJA',($TOTALSIAPKERJA))
            // ->description('PMI Terdaftar SiapKerja')
            // ->descriptionIcon('heroicon-o-clipboard-check')
            // ->color('success')
            // ->chart([7, 2, 12, 23, 60, 4, 41]),

            // Card::make('VERIFIKASI SIAPKERJA',($TOTALVERDATA))
            // ->description('PMI Terverifikasi SiapKerja')
            // ->descriptionIcon('heroicon-o-clipboard-check')
            // ->color('success')
            // ->chart([7, 50, 12, 23, 60, 4, 17]),

            Card::make('ID CPMI',($TOTALVERPP))
            ->description('ID SiapKerja')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success')
            ->chart([30, 2, 58, 3, 15, 4, 17]),

            Card::make('PMI FINISH',($PMIFINISH))
            ->description('Total PMI Finish')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('success')
            ->chart([7, 2, 58, 3, 15, 4, 17]),
            
            Card::make('PMI MD',($PMIMD))
            ->description('PMI Mengundurkan Diri')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('danger')
            ->chart([70, 2, 12, 3, 15, 4, 2]),

            Card::make('PMI PENDING',($PMIPENDING))
            ->description('PMI Pending')
            ->descriptionIcon('heroicon-o-clipboard-check')
            ->color('warning')
            ->chart([7, 10, 58, 3, 15, 4, 2]),
            
            
            // Card::make('FIT',($FIT))
            // ->description('CPMI FIT')
            // ->descriptionIcon('heroicon-o-clipboard-check')
            // ->color('success')
            // ->chart([70, 2, 12, 3, 15, 4, 2]),

            // Card::make('UNFIT',($UNFIT))
            // ->description('CPMI UNFIT')
            // ->descriptionIcon('heroicon-o-clipboard-check')
            // ->color('warning')
            // ->chart([7, 10, 58, 3, 15, 4, 2]),
        ];
    }
}
