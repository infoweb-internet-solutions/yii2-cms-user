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

use dektrium\user\models\User as BaseUser;

use dektrium\user\helpers\Password;
use yii\helpers\Security;

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
 * @property string  $role
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
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', Security::generateRandomKey());
            //$this->setAttribute('role', $this->module->defaultRole);
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }
}
