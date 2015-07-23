<?php

namespace infoweb\user\models;

class WebUser extends \yii\web\User
{
    public $identityClass = 'infoweb\user\models\User';
    
    public $loginUrl = ['user/security/login'];    
}