<?php

namespace infoweb\user\models\frontend;

use Yii;
use yii\web\User as BaseUser;

class User extends BaseUser
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
        
    public $identityClass = 'infoweb\user\models\User';
    
    public $loginUrl = ['user/security/login'];
    
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
