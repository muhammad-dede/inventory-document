<?php

namespace App\Filament\Widgets;

use App\Models\Pic;
use App\Models\Product;
use App\Models\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $section_count = Section::count();
        $pic_count = Pic::count();
        $product_count = Product::count();
        return [
            Stat::make('Seksi', $section_count)
                ->description('Total Seksi')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('PIC', $pic_count)
                ->description('Total PIC')
                ->color('danger')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Barang', $product_count)
                ->description('Total Barang')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
