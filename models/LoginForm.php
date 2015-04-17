<?php

namespace infoweb\user\models;

use yii\base\Model;
use dektrium\user\models\LoginForm as BaseLoginForm;
use infoweb\user\Finder;

class LoginForm extends BaseLoginForm
{
    /**
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Finder $finder, $config = [])
    {        
        // Override the singleton instance for the Finder that is set in 
        // the DI container of the Boostrap class of this module so that our custom Finder is used
        \Yii::$container->setSingleton(Finder::className(), [
            'userQuery'    => \Yii::$container->get('UserQuery'),
            'profileQuery' => \Yii::$container->get('ProfileQuery'),
            'tokenQuery'   => \Yii::$container->get('TokenQuery'),
            'accountQuery' => \Yii::$container->get('AccountQuery'),
        ]);
        
        $this->finder = \Yii::$container->get(Finder::className());
        $this->module = \Yii::$app->getModule('user');
        Model::__construct($config);
    }    
}