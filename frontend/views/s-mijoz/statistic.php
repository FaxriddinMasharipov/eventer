<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
?>

<?php
$rand = array();
for ($i=1; $i<=5; $i++)
{
    array_push($rand,rand(1,1000));
}
?>
<div class="row">
    <div class="col-md-6">
        <?= ChartJs::widget([
            'type' => 'line',
            'clientOptions' => [
                'height' => 50,
                'width' => 100,
//        'scales' => [
//            'xAxes' => [['stacked' => true]],
//            'yAxes' => [['stacked' => true]],
//        ]
            ],
            'data' => [
                'labels' => ["Yanvar", "Fevral", "Mart", "Aprel", "May"],
                'datasets' => [
                    [
                        'label' => "Oylar bo'yicha",
                        'backgroundColor' => "rgba(162,124,92,0.2)",
                        'borderColor' => "rgba(162,124,92,1)",
                        'pointBackgroundColor' => "rgba(162,124,92,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(162,124,92,1)",
                        'data' => $rand,
                    ],
                ]
            ]
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?= ChartJs::widget([
            'type' => 'bar',
            'clientOptions' => [
                'height' => 50,
                'width' => 100,
            ],
            'data' => [
                'labels' => ["Yanvar", "Fevral", "Mart", "Aprel", "May"],
                'datasets' => [
                    [
                        'label' => "Oylar bo'yicha",
                        'backgroundColor' => "rgba(162,124,92,0.2)",
                        'borderColor' => "rgba(162,124,92,1)",
                        'pointBackgroundColor' => "rgba(162,124,92,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(162,124,92,1)",
                        'data' => $rand,
                    ],
                ]
            ]
        ]);
        ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= ChartJs::widget([
                'type' => 'horizontalBar',
                'data' => [
                    'labels' => ["Yanvar", "Fevral", "Mart", "Aprel", "May"],
                    'datasets' => [
                        [
                            'label' => "Oylar bo'yicha",
                            'backgroundColor' => "rgba(162,124,92,0.2)",
                            'borderColor' => "rgba(162,124,92,1)",
                            'pointBackgroundColor' => "rgba(162,124,92,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(162,124,92,1)",
                            'data' => $rand,
                        ],
                    ]
                ]
            ]);?>
        </div>
        <div class="col-md-6">
            <?php echo ChartJs::widget([
                'type' => 'pie',
                'id' => 'structurePie',
                'options' => [
                    'height' => 200,
                    'width' => 400,
                ],
                'data' => [
                    'radius' =>  "90%",
                    'labels' => ['Label 1', 'Label 2', 'Label 3'], // Your labels
                    'datasets' => [
                        [
                            'data' => ['35.6', '17.5', '46.9'], // Your dataset
                            'label' => '',
                            'backgroundColor' => [
                                '#ADC3FF',
                                '#FF9A9A',
                                'rgba(190, 124, 145, 0.8)'
                            ],
                            'borderColor' =>  [
                                '#fff',
                                '#fff',
                                '#fff'
                            ],
                            'borderWidth' => 1,
                            'hoverBorderColor'=>["#999","#999","#999"],
                        ]
                    ]
                ],
                'clientOptions' => [
                    'legend' => [
                        'display' => false,
                        'position' => 'bottom',
                        'labels' => [
                            'fontSize' => 14,
                            'fontColor' => "#425062",
                        ]
                    ],
                    'tooltips' => [
                        'enabled' => true,
                        'intersect' => true
                    ],
                    'hover' => [
                        'mode' => false
                    ],
                    'maintainAspectRatio' => false,

                ],])
            ?>
        </div>
    </div>
</div>