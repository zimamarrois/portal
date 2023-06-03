<?php

namespace App\Filament\Widgets;


use Kenepa\MultiWidget\MultiWidget;
use App\Filament\Resources\DataPmiResource\Widgets\DataPmiOverview;
use App\Filament\Resources\DataPmiResource\Widgets\PmiStatus;
use App\Filament\Resources\DataPmiResource\Widgets\SiapKerjaOverview;

class DSOverview extends MultiWidget
{
    public array $widgets = [
        DataPmiOverview::class,
        PmiStatus::class,
        SiapKerjaOverview::class,
    ];
}