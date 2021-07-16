<?php
use yii\helpers\Html;
?>
<aside class="main-sidebar" style="background-color: rgba(68,108,246,0.77)">
    <section class="sidebar">
        <h2>
            <?=Yii::$app->getUser()->identity->username?>

        </h2>
        <!-- Sidebar user panel -->
        <hr>
        <!-- search form -->
        <?php echo dmstr\widgets\Menu::widget(
            ['options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => "Bosh sahifa", 'icon' => 'home', 'url' => ['/site/index']],
                    ['label' => "Narxlar", 'icon' => 'bookmark', 'url' => ['/site/kriditorlar']],
                    ['label' => "Fayllar", 'icon' => 'bookmark', 'url' => ['/site/dillers']],
                    ['label' => "Buytumalar", 'icon' => 'bookmark', 'url' => ['/site/kirim']],
                    ['label' => "Haridorlar", 'icon' => 'bookmark', 'url' => ['/site/haridor']],
                    ['label' => "Xizmatlar", 'icon' => 'shopping-cart', 'url' => ['/site/mahsulot']],
                    ['label' => "To'lovnomlar", 'icon' => 'shopping-cart', 'url' => ['/site/tolovnomlar']],
                    ['label' => "Serialar", 'icon' => 'shopping-cart', 'url' => ['/site/serialar']],
                    ['label' => "Xarajat turlari", 'icon' => 'shopping-cart', 'url' => ['/site/xarajatturlari']],
                    ['label' => "Ombor", 'icon' => 'bookmark', 'url' => ['/site/ombor']],
                    ['label' => "Xizmat turlari", 'icon' => 'clock-o', 'url' => ['/site/kun']],
                    ['label' => "Qarzdorlik", 'icon' => 'money', 'url' => ['/site/client-qarz']],
                    ['label' => "Ходимлар кеcимида",  'icon' => 'clock-o', 'url' => ['/site/ofisiant']],

//                    ['label' => "Мижозлар рейтинги", 'icon' => 'users', 'url' => ['/site/klent']],
//                    ['label' => "Назорат рейтинги", 'icon' => 'bar-chart', 'url' => ['/site/reyting']],
//                    ['label' => "Статистика", 'icon' => 'th-list', 'url' => ['/site/statistic']],
//					 ['label' => "Ходимлар", 'icon' => 'user', 'url' => ['/s-user/index']],
                    ['label' => "Ro'yxatdan o'tish", 'icon' => 'plus', 'url' => ['/site/signup']],

                    /*Yii::$app->user->isGuest ? (
                       ['label' => 'login',url => ['/site/login']]
                    ) : (
                        '<li>'
                        . Html::beginForm(['/site/logout'],'post')
                        . Html::submitButton(
                            'Logout (' . Yii::$app->getUser()->identity->username . ')',
                            ['class' => 'btn btn link']
                            )
                        . Html::endForm()
                        . '</li>'
                    ),*/
['label' =>'Chiqish', 'icon' => 'minus', 'url' => ['/site/logout'],
    'template'=>'<a href="{url}" data-method="post">{label}</a>'],
['label' => 'Chiqish','icon' => 'minus','url' => ['/site/logout'],
'template' => '<li>'.Html::beginForm(array('/site/logout')) . Html::submitButton('Chiqish') . Html::endForm().'</li>',
],
]]);?>
    </section>
</aside>