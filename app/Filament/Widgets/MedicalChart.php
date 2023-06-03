<?php

namespace App\Filament\Widgets;

use App\Models\DataPmi;
use App\Models\Kantor;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MedicalChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'medicalChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'MedicalChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hari ini',
            'thisWeek' => 'Minggu ini',
            'thisMonth' => 'Bulan ini',
        ];
    }
    protected function getOptions(): array
    {
        $activeFilter = $this->filter;

        switch ($activeFilter) {
            case 'today':
                $dari = now()->startOfDay();
                break;
            case 'thisWeek':
                $dari = now()->startOfWeek();
                break;
            case 'thisMonth':
                $dari = now()->startOfMonth();
            default:
                $dari = now()->startOfDay();
        }

        $semuaKantor = Kantor::all()->pluck('id');

        $medicalCounts = [];

        foreach ($semuaKantor as $id) {
            $count = DataPmi::where('kantor_id','1', $id)
                ->where('medical_check', 1)
                ->when(
                    $activeFilter,
                    fn ($q) => $q->whereBetween('created_at', [$dari, now()])
                )
                ->count();

            $medicalCounts1[] = $count;
        }

        $semuaKantor = Kantor::all()->pluck('id');

        $medicalCounts = [];

        foreach ($semuaKantor as $id) {
            $count = DataPmi::where('kantor_id','2', $id)
                ->where('medical_check', 1)
                ->when(
                    $activeFilter,
                    fn ($q) => $q->whereBetween('created_at', [$dari, now()])
                )
                ->count();

            $medicalCounts2[] = $count;
        }

        $semuaKantor = Kantor::all()->pluck('id');

        $medicalCounts = [];

        foreach ($semuaKantor as $id) {
            $count = DataPmi::where('kantor_id','3', $id)
                ->where('medical_check', 1)
                ->when(
                    $activeFilter,
                    fn ($q) => $q->whereBetween('created_at', [$dari, now()])
                )
                ->count();

            $medicalCounts3[] = $count;
        }

        $semuaKantor = Kantor::all()->pluck('id');

        $medicalCounts = [];

        foreach ($semuaKantor as $id) {
            $count = DataPmi::where('kantor_id','4', $id)
                ->where('medical_check', 1)
                ->when(
                    $activeFilter,
                    fn ($q) => $q->whereBetween('created_at', [$dari, now()])
                )
                ->count();

            $medicalCounts4[] = $count;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 200,
            ],
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => [
                        $medicalCounts1,
                        $medicalCounts2,
                        $medicalCounts3,
                        $medicalCounts4,
                    ],
                ],
            ],
        ];
    }
}
