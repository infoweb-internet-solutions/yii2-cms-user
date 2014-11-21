<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace infoweb\user\models;

//use yii\web\User as BaseUser;

class WebUser extends \yii\web\User
{
    public $identityClass = 'infoweb\user\models\User';
    
    public $loginUrl = ['user/security/login'];    
}
