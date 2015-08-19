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

use Yii;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User as BaseUser;
use dektrium\user\helpers\Password;
use dektrium\user\models\Token;

/**
 * User ActiveRecord model.
 *
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property string  $password_hash
 * @property string  $auth_key
 * @property integer $registered_from
 * @property integer $logged_in_from
 * @property integer $logged_in_at
 * @property string  $confirmation_token
 * @property integer $confirmation_sent_at
 * @property integer $confirmed_at
 * @property string  $unconfirmed_email
 * @property string  $recovery_token
 * @property integer $recovery_sent_at
 * @property integer $blocked_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $confirmationUrl
 * @property boolean $isConfirmed
 * @property boolean $isConfirmationPeriodExpired
 * @property string  $recoveryUrl
 * @property boolean $isRecoveryPeriodExpired
 * @property boolean $isBlocked
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class User extends BaseUser
{    
    // Scope constants
    const SCOPE_BACKEND     = 'backend';
    const SCOPE_FRONTEND    = 'frontend';
    const SCOPE_BOTH        = 'both';
    
    public function rules()
    {
        $rules = parent::rules();
        
        // Update the 'usernameLength' rule
        $rules['usernameLength'] = ['username', 'string', 'min' => 3, 'max' => 255];
        
        return $rules;    
    }
    
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'image' => [
                'class' => 'infoweb\cms\behaviors\ImageBehave',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('user', 'Username'),
            'email' => \Yii::t('user', 'Email'),
            'password' => \Yii::t('user', 'Password'),
            'created_at' => \Yii::t('user', 'Registration time'),
            'registered_from' => \Yii::t('user', 'Registered from'),
            'unconfirmed_email' => \Yii::t('user', 'Unconfirmed email'),
            'current_password' => \Yii::t('user', 'Current password'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', Yii::$app->getSecurity()->generateRandomKey());
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }
    
    /**
     * Finds a token by user id and code.
     *
     * @param mixed $condition
     *
     * @return ActiveQuery
     */
    public function getPasswordResetToken()
    {
        return $this->finder->tokenQuery->where(['user_id' => $this->id, 'type' => Token::TYPE_RECOVERY]);
    }
}
