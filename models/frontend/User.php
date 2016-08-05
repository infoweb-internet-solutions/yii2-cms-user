<?php

namespace infoweb\user\models\frontend;

use Yii;
use yii\db\ActiveRecord;
use infoweb\user\models\User as BaseUser;
use infoweb\user\models\Profile;
use infoweb\agenda\models\item\Item as AgendaItem;

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
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Finds user by email
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'scope' => [self::SCOPE_FRONTEND, self::SCOPE_BOTH]]);
    }

    /**
     * Finds user by sso_id
     *
     * @param string $username
     * @return static|null
     */
    public static function findBySsoId($sso_id)
    {
        return static::findOne(['sso_id' => $sso_id, 'scope' => [self::SCOPE_FRONTEND, self::SCOPE_BOTH]]);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'scope' => [self::SCOPE_FRONTEND, self::SCOPE_BOTH]]);
    }
    
     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'scope' => [self::SCOPE_FRONTEND, self::SCOPE_BOTH]]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'scope' => [self::SCOPE_FRONTEND, self::SCOPE_BOTH],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaItems()
    {
        return $this->hasMany(AgendaItem::className(), ['id' => 'agenda_item_id'])
                    ->viaTable('user_agenda_items', ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaRegistrations()
    {
        return $this->hasMany(AgendaItem::className(), ['id' => 'agenda_item_id'])
                    ->viaTable('user_agenda_registrations', ['user_id' => 'id']);
    }
}