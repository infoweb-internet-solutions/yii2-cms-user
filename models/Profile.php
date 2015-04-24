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
    const PROFESSION_PNEUMOLOGIST   = 'pneumologist';
    const PROFESSION_ALLERGIST      = 'allergist';
    const PROFESSION_NKO            = 'nko';
    const PROFESSION_INTERNIST      = 'internist';
    const PROFESSION_DOCTOR         = 'doctor';
    const PROFESSION_NURSE          = 'nurse';
    const PROFESSION_PHARMACIST     = 'pharmacist';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salutation', 'name', 'firstname', 'public_email', 'address', 'profession'], 'required'],
            [['name', 'firstname', 'public_email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'workplace_name', 'responsible_pneumologist'], 'trim'],
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
            self::PROFESSION_PNEUMOLOGIST   => Yii::t('infoweb/user', 'Pneumologist'),
            self::PROFESSION_ALLERGIST      => Yii::t('infoweb/user', 'Allergist'),
            self::PROFESSION_NKO            => Yii::t('infoweb/user', 'NKO'),
            self::PROFESSION_INTERNIST      => Yii::t('infoweb/user', 'Internist'),
            self::PROFESSION_DOCTOR         => Yii::t('infoweb/user', 'Doctor'),
            self::PROFESSION_NURSE          => Yii::t('infoweb/user', 'Nurse'),
            self::PROFESSION_PHARMACIST     => Yii::t('infoweb/user', 'Pharmacist')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'public_email'                      => Yii::t('user', 'Email'),
            'salutation'                        => Yii::t('infoweb/user', 'Salutation'),
            'firstname'                         => Yii::t('infoweb/user', 'Firstname'),
            'name'                              => Yii::t('infoweb/user', 'Name'),
            'profession'                        => Yii::t('infoweb/user', 'Profession'),
            'riziv_number'                      => Yii::t('infoweb/user', 'Riziv number'),
            'apb_number'                        => Yii::t('infoweb/user', 'APB number'),
            'workplace_name'                    => Yii::t('infoweb/user', 'Workplace name'),
        ]);
    }
}