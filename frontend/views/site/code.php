<?php

use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: MRK
 * Date: 26.10.2018
 * Time: 13:09
 */

?>
<br>
<br>
<div class="container">
    <img src="<?=Yii::$app->request->baseUrl?>/image/<?=$post?>.png" alt="Avatar" class="image">
    <div class="overlay">
        <div class="text"><a class="btn btn-danger  " href="<?=Yii::$app->request->baseUrl?>/image/<?=$post?>.png">DOWNLOAD</a></div>
    </div>
</div>
<style>
    .container {
        position: relative;
        width: 70%;
    }

    .image {
        display: block;
        width: 100%;
        height: auto;
    }

    .overlay {

        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: #8278ff;
    }

    .container:hover .overlay {
        opacity: 0.9;
    }

    .text {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>