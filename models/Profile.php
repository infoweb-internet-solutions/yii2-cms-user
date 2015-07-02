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
    // Salutation constants
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';
    
    // Workplacetype constants
    const WORKPLACETYPE_HOSPITAL    = 'hospital';
    const WORKPLACETYPE_PRIVATE     = 'private';
    
    // Profession constants
    const PROFESSION_PNEUMOLOGIST       = 'pneumologist';
    const PROFESSION_ALLERGIST          = 'allergist';
    const PROFESSION_NKO                = 'nko';
    const PROFESSION_INTERNIST          = 'internist';
    const PROFESSION_DOCTOR             = 'doctor';
    const PROFESSION_NURSE              = 'nurse';
    const PROFESSION_PHARMACIST         = 'pharmacist';
    const PROFESSION_PHYSIOTHERAPIST    = 'physiotherapist';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salutation', 'name', 'firstname', 'public_email', 'address', 'profession', 'language'], 'required'],
            [['name', 'firstname', 'public_email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'workplace_name', 'responsible_pneumologist'], 'trim'],
            ['language', 'string', 'max' => 2],
            ['language', 'default', 'value' => Yii::$app->language],
            ['newsletter', 'number'],
            ['public_email', 'email'],
            // Emailaddress has to be unique
            ['public_email', 'unique', 'targetClass' => 'infoweb\user\models\frontend\User', 'targetAttribute' => 'email', 'message' => Yii::t('infoweb/user', 'This email address has already been taken.')],
            // Nurses and pneumologists must have a specific workplace_type
            ['workplace_type', 'in', 'range' => [Profile::WORKPLACETYPE_HOSPITAL, Profile::WORKPLACETYPE_PRIVATE], 'when' => function($model) {
                return in_array($model->profession, [Profile::PROFESSION_PNEUMOLOGIST, Profile::PROFESSION_NURSE]);
            }],
            // Nurses and pneumologists must have a workplace_name
            ['workplace_name', 'required', 'when' => function($model) {
                return in_array($model->profession, [Profile::PROFESSION_PNEUMOLOGIST, Profile::PROFESSION_NURSE]);
            }],
            // Pharmacists need an APB number
            ['apb_number', 'required', 'when' => function($model) {
                return $model->profession == Profile::PROFESSION_PHARMACIST;
            }],
            // All the rest needs a riziv number
            ['riziv_number', 'required', 'when' => function($model) {
                return !in_array($model->profession, [Profile::PROFESSION_PHARMACIST, '']);
            }]
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
     * Returns the professions
     * 
     * @return  array
     */
    public static function professions()
    {
        return [
            self::PROFESSION_PNEUMOLOGIST       => Yii::t('frontend', 'Pneumoloog'),
            self::PROFESSION_ALLERGIST          => Yii::t('frontend', 'Allergoloog'),
            self::PROFESSION_NKO                => Yii::t('frontend', 'NKO'),
            self::PROFESSION_INTERNIST          => Yii::t('frontend', 'Internist'),
            self::PROFESSION_DOCTOR             => Yii::t('frontend', 'Huisarts'),
            //self::PROFESSION_NURSE              => Yii::t('frontend', 'Verpleegkundige'),
            self::PROFESSION_PHYSIOTHERAPIST    => Yii::t('frontend', 'Kinesist'),
            self::PROFESSION_PHARMACIST         => Yii::t('frontend', 'Apotheker')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'public_email'                      => Yii::t('frontend', 'E-mailadres'),
            'salutation'                        => Yii::t('frontend', 'Aanspreking'),
            'firstname'                         => Yii::t('frontend', 'Voornaam'),
            'name'                              => Yii::t('frontend', 'Naam'),
            'profession'                        => Yii::t('frontend', 'Beroep'),
            'riziv_number'                      => Yii::t('frontend', 'Riziv nummer'),
            'apb_number'                        => Yii::t('frontend', 'APB nummer'),
            'workplace_name'                    => Yii::t('infoweb/user', 'Workplace name'),
            'language'                          => Yii::t('frontend', 'Taal'),
            'address'                           => Yii::t('frontend', 'Adres'),
            'zipcode'                           => Yii::t('frontend', 'Postcode'),
            'city'                              => Yii::t('frontend', 'Gemeente'),
            'phone'                             => Yii::t('frontend', 'Telefoon'),
            'mobile'                            => Yii::t('frontend', 'GSM'),
        ]);
    }
}