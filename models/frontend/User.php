<?php

namespace infoweb\user\models\frontend;

use Yii;
use yii\db\ActiveRecord;
use infoweb\user\models\User as BaseUser;

class User extends BaseUser
{   
    public $identityClass = 'infoweb\user\models\User';
    
    public $loginUrl = ['site/login'];
    
    /** @inheritdoc */
    public function scenarios()
    {
        return ActiveRecord::scenarios();
    }        
    
    /**
     * Custom implementation because the parent class created the Profile object
     * in this function.
     * 
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        ActiveRecord::afterSave($insert, $changedAttributes);
    }    
}
