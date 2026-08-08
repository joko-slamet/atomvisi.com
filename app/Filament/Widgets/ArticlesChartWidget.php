<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class ArticlesChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Artikel Dipublikasikan (6 Bulan Terakhir)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn (int $i) => now()->subMonths($i)->startOfMonth());

        $counts = $months->map(function ($month) {
            return Article::published()
                ->whereBetween('published_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Artikel',
                    'data' => $counts->toArray(),
                    'borderColor' => '#d8b441',
                    'backgroundColor' => 'rgba(216, 180, 65, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $months->map(fn ($month) => $month->translatedFormat('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
