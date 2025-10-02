<?php

namespace App\Charts;

use marineusde\LarapexCharts\Charts\PieChart AS OriginalPieChart;

class KecamatanChart
{
    public function build(): OriginalPieChart
    {
        return (new OriginalPieChart )
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData([40, 50, 30])
            ->setLabels(['Player 7', 'Player 10', 'Player 9']);
    }
}
