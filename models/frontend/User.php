<?php

namespace infoweb\user\models\frontend;

use Yii;
use yii\web\User as BaseUser;

class User extends BaseUser
{
    // Salutation constants
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';
        
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
            'pneumologist'          => Yii::t('infoweb/user', 'Pneumologist'),
            'allergist'             => Yii::t('infoweb/user', 'Allergist'),
            'nko'                   => Yii::t('infoweb/user', 'NKO'),
            'internist'             => Yii::t('infoweb/user', 'Internist'),
            'doctor'                => Yii::t('infoweb/user', 'Doctor'),
            'nurse'                 => Yii::t('infoweb/user', 'Nurse'),
            'pharmacist'            => Yii::t('infoweb/user', 'Pharmacist')
        ];
    }    
}
