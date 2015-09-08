<?php
namespace infoweb\user\models;

use dektrium\user\helpers\Password;
use dektrium\user\Mailer;
use dektrium\user\Module;
use Yii;
use yii\base\Model;
use dektrium\user\models\SettingsForm as Base;

class SettingsForm extends Base
{
    /** @inheritdoc */
    public function rules()
    {
        return [
            'usernameRequired' => ['username', 'required'],
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernameLenth' => ['username', 'string', 'min' => 3, 'max' => 20],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'emailRequired' => ['email', 'required'],
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailPattern' => ['email', 'email'],
            'emailUsernameUnique' => [['email', 'username'], 'unique', 'when' => function ($model, $attribute) {
                return $this->user->$attribute != $model->$attribute;
            }, 'targetClass' => $this->module->modelMap['User']],
            'newPasswordLength' => ['new_password', 'string', 'min' => 6],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'            => Yii::t('user', 'Email'),
            'username'         => Yii::t('user', 'Username'),
            'new_password'     => Yii::t('user', 'New password'),
        ];
    }
}
