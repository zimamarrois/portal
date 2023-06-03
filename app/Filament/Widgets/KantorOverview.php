<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DataPmiResource\Widgets\BatangOverview;
use App\Filament\Resources\DataPmiResource\Widgets\BrebesOverview;
use App\Filament\Resources\DataPmiResource\Widgets\KendalOverview;
use App\Filament\Resources\DataPmiResource\Widgets\WeleriOverview;
use Kenepa\MultiWidget\MultiWidget;


class KantorOverview extends MultiWidget
{
    public array $widgets = [
        KendalOverview::class,
        BatangOverview::class,
        BrebesOverview::class,
        WeleriOverview::class,
        
    ];
}
