<?php

namespace infoweb\user\components;

use yii\di\Instance;
use mdm\admin\components\AccessControl as BaseAccessControl;

class AccessControl extends BaseAccessControl
{    
    public function init()
    {
        if (defined('STDIN'))
            return true;
        
        parent::init();
    }
    
    public function beforeFilter($event)
    {
        if (defined('STDIN'))
            return true;
        
        return parent::beforeFilter($event);    
    }
    
    public function beforeAction($action)
    {
        if (defined('STDIN'))
            return true;
        
        return parent::beforeAction($action);    
    }    
}