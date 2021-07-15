<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',



        'temp/Login_v1/css/main.css',

    ];
    public $js = [
        
        'temp/Login_v1/vendor/jquery/jquery-3.2.1.min.js',
        'temp/Login_v1/vendor/bootstrap/js/popper.js',
        'temp/Login_v1/vendor/bootstrap/js/bootstrap.min.js',
        'temp/Login_v1/vendor/select2/select2.min.js',
        'temp/Login_v1/vendor/tilt/tilt.jquery.min.js',
        'temp/Login_v1/js/main.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
