<?php
namespace infoweb\user\assets\frontend;

use yii\web\AssetBundle as AssetBundle;

class SignupAsset extends AssetBundle
{
    public $sourcePath = '@infoweb/user/assets/frontend/';

    public $css = [
        'css/signup.css'
    ];
    
    public $js = [
        'js/signup.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}