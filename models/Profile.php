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
}