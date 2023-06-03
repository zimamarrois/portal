<?php

namespace App\Filament\Resources\DataPmiResource\Widgets;

use Filament\Widgets\PolarAreaChartWidget;

class StatusUpdateChart extends PolarAreaChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }
}
