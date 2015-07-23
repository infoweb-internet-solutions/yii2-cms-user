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
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use dektrium\user\models\Profile as BaseProfile;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class Profile extends BaseProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'firstname', 'public_email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'fax'], 'trim'],
            ['language', 'string', 'max' => 2],
            ['language', 'default', 'value' => Yii::$app->language],
            ['public_email', 'email'],
            // Emailaddress has to be unique
            ['public_email', 'unique', 'targetClass' => 'infoweb\user\models\frontend\User', 'targetAttribute' => 'email', 'message' => Yii::t('infoweb/user', 'This email address has already been taken.')],
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() { return time(); },
            ],
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
        return ArrayHelper::merge(parent::attributeLabels(), [
            'public_email'                      => Yii::t('infoweb/user', 'Email'),
            'firstname'                         => Yii::t('infoweb/user', 'Firstname'),
            'name'                              => Yii::t('infoweb/user', 'Name'),            
            'language'                          => Yii::t('infoweb/user', 'Language'),
            'address'                           => Yii::t('infoweb/user', 'Address'),
            'zipcode'                           => Yii::t('infoweb/user', 'Zipcode'),
            'city'                              => Yii::t('infoweb/user', 'City'),
            'phone'                             => Yii::t('infoweb/user', 'Phone'),
            'mobile'                            => Yii::t('infoweb/user', 'Mobile'),
            'fax'                               => Yii::t('infoweb/user', 'Fax'),
        ]);
    }
    
    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne('\infoweb\user\models\User', ['id' => 'user_id']);
    }
}