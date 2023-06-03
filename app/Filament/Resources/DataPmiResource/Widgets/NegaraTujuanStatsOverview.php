<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use App\Models\Tujuan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class NegaraTujuanStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $hk = Tujuan::where('negara_tujuan', 'Hongkong')->withCount('DataPmi')->first();
        $tw = Tujuan::where('negara_tujuan', 'Taiwan')->withCount('DataPmi')->first();
        $sg = Tujuan::where('negara_tujuan', 'Singapura')->withCount('DataPmi')->first();
        $my = Tujuan::where('negara_tujuan', 'Malaysia')->withCount('DataPmi')->first();
        return [
            Card::make($hk->negara_tujuan, $hk->data_pmi_count)
            ->description('Tujuan P3MI')
            ->descriptionIcon('heroicon-o-check-circle'),
            Card::make($tw->negara_tujuan, $tw->data_pmi_count)
            ->description('Tujuan P3MI')
            ->descriptionIcon('heroicon-o-check-circle'),
            Card::make($sg->negara_tujuan, $sg->data_pmi_count)
            ->description('Tujuan P3MI')
            ->descriptionIcon('heroicon-o-check-circle'),
            Card::make($my->negara_tujuan, $my->data_pmi_count)
            ->description('Tujuan P3MI')
            ->descriptionIcon('heroicon-o-check-circle'),
        ];
    }
}
