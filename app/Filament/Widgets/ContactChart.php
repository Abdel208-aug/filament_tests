<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;

class ContactChart extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?string $pollingInterval = '0.4';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Contacts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45,],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct' ],
        ];
    }
}
