<?php

namespace App\Filament\Widgets;

use App\Models\Retrieval;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class RetrievalChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static string $chartId = 'retrieval';

    protected static ?string $heading = 'Statistik Pengambilan Barang';

    public ?string $filter = null;

    public function mount(): void
    {
        $this->filter = now()->year;
    }

    protected function getFilters(): array
    {
        return Retrieval::query()
            ->selectRaw('DISTINCT YEAR(retrieval_date) as year')
            ->whereNotNull('retrieval_date')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->mapWithKeys(fn($year) => [(string) $year => (string) $year])
            ->toArray();
    }

    protected function getData(): array
    {
        $year = $this->filter;

        $data = Trend::model(Retrieval::class)
            ->dateColumn('retrieval_date')
            ->between(
                start: Carbon::create($year)->startOfYear(),
                end: Carbon::create($year)->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => "Tahun $year",
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(function (TrendValue $value) {
                $date = Carbon::createFromFormat('Y-m', $value->date);
                return $date->format('M');
            }),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
