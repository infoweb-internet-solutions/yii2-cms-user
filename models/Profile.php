<?php
namespace infoweb\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use dektrium\user\models\Profile as BaseProfile;
use infoweb\flexmail\behaviors\ContactBehavior;

class Profile extends BaseProfile
{
    // Login types
    CONST LOGIN_TYPE_SITE = 'SITE';
    CONST LOGIN_TYPE_SSO = 'SSO';

    // Registration sources
    CONST REGISTRATION_SOURCE_SITE = 'SITE';
    CONST REGISTRATION_SOURCE_SSO = 'SSO';
    CONST REGISTRATION_SOURCE_SANMAX = 'SANMAX';

    // Salutation constants
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';

    // Workplacetype constants
    const WORKPLACETYPE_HOSPITAL    = 'hospital';
    const WORKPLACETYPE_PRIVATE     = 'private';

    // Profession constants
    const PROFESSION_PNEUMOLOGIST           = 'pneumologist';
    const PROFESSION_PNEUMOLOGIST_ASSISTANT = 'pneumologist-assistent';
    const PROFESSION_ALLERGIST              = 'allergist';
    const PROFESSION_NKO                    = 'nko';
    const PROFESSION_INTERNIST              = 'internist';
    const PROFESSION_DOCTOR                 = 'doctor';
    const PROFESSION_NURSE                  = 'nurse';
    const PROFESSION_PHARMACIST             = 'pharmacist';
    const PROFESSION_PHYSIOTHERAPIST        = 'physiotherapist';

    const COUNTRY_LU = 'LU';
    const COUNTRY_BE = 'BE';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salutation', 'name', 'firstname', 'public_email', 'address', 'zipcode', 'city', 'profession', 'language'], 'required'],
            [['name', 'firstname', 'public_email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'workplace_name', 'responsible_pneumologist'], 'trim'],
            ['language', 'string', 'max' => 2],
            ['language', 'default', 'value' => Yii::$app->language],
            ['country', 'default', 'value' => Profile::COUNTRY_BE],
            ['newsletter', 'number'],
            ['public_email', 'email'],
            // Emailaddress has to be unique
            [
                'public_email',
                'unique',
                'message' => Yii::t('infoweb/user', 'This email address has already been taken.'),
                'filter' => function($query) {
                    // Check if the emailadddress does not exist in the user table
                    $query->joinWith('user')->where(['email' => $this->public_email]);
                    return $query;
                }
            ],
            // Nurses and pneumologists must have a specific workplace_type
            ['workplace_type', 'in', 'range' => [Profile::WORKPLACETYPE_HOSPITAL, Profile::WORKPLACETYPE_PRIVATE], 'when' => function($model) {
                return in_array($model->profession, [Profile::PROFESSION_PNEUMOLOGIST, Profile::PROFESSION_PNEUMOLOGIST_ASSISTANT, Profile::PROFESSION_NURSE]);
            }],
            // Nurses and pneumologists must have a workplace_name
            ['workplace_name', 'required', 'when' => function($model) {
                return in_array($model->profession, [Profile::PROFESSION_PNEUMOLOGIST, Profile::PROFESSION_PNEUMOLOGIST_ASSISTANT, Profile::PROFESSION_NURSE]);
            }],
            // A nurse must have a responsible pneumologist
            ['responsible_pneumologist', 'required', 'when' => function($model) {
                return in_array($model->profession, [Profile::PROFESSION_NURSE, Profile::PROFESSION_PNEUMOLOGIST_ASSISTANT]);
            }],
            // Pharmacists need an APB number
            ['apb_number', 'required', 'when' => function($model) {
                return $model->profession == Profile::PROFESSION_PHARMACIST;
            }],
            // All the rest needs a riziv number
            ['riziv_number', 'required', 'when' => function($model) {
                if($model->country == Profile::COUNTRY_BE) {
                    return !in_array($model->profession, [Profile::PROFESSION_PHARMACIST, Profile::PROFESSION_NURSE, '']);
                }

                return false;
            }],
            // 
            ['doctorcode', 'required', 'when' => function($model) {
                if($model->country == Profile::COUNTRY_LU) {
                    return !in_array($model->profession, [Profile::PROFESSION_PHARMACIST, Profile::PROFESSION_NURSE, '']);
                }

                return false;
            }],
            ['riziv_number', 'match', 'pattern' => '/^[0-9]{1}-[0-9]{5}-[0-9]{2}-[0-9]{3}$/'],
            ['apb_number', 'match', 'pattern' => '/^[0-9]{6}$/'],
            ['registration_source', 'string']
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
            'flexmailContact' => [
                'class' => ContactBehavior::className(),
                'mailingListId' => Yii::$app->params['flexmailMailingLists']['members'],
                'contactAttributes' => [
                    'emailAddress' => 'public_email',
                    'name'         => 'firstname',
                    'surname'      => 'name',
                    'address'      => 'address',
                    'zipcode'      => 'zipcode',
                    'city'         => 'city',
                    'phone'        => 'phone',
                    'fax'          => 'fax',
                    'mobile'       => 'mobile',
                    'language'     => 'language',
                    'title'        => 'salutation',
                    'function'     => 'profession'
                ],
                'attributeFilters' => [
                    'salutation' => function($value) {
                        return (new self)->salutations()[$value];
                    },
                    'profession' => function($value) {
                        return isset(self::professions()[$value]) ? self::professions()[$value] : '';
                    }
                ]
            ]
        ]);
    }

    public static function registrationSources() {
        return [
            self::REGISTRATION_SOURCE_SITE => Yii::t('frontend', 'Site'),
            self::REGISTRATION_SOURCE_SSO => Yii::t('frontend', 'SSO'),
            self::REGISTRATION_SOURCE_SANMAX => Yii::t('frontend', 'Sanmax'),
        ];
    }

    public static function loginTypes() {
        return [
            self::LOGIN_TYPE_SITE => Yii::t('frontend', 'Site'),
            self::LOGIN_TYPE_SSO => Yii::t('frontend', 'SSO')
        ];
    }

    /**
     * Returns the professions
     *
     * @return  array
     */
    public static function professions()
    {
        return [
            self::PROFESSION_PNEUMOLOGIST           => Yii::t('frontend', 'Pneumoloog'),
            self::PROFESSION_PNEUMOLOGIST_ASSISTANT => Yii::t('frontend', 'Assistent pneumoloog'),
            self::PROFESSION_ALLERGIST              => Yii::t('frontend', 'Allergoloog'),
            self::PROFESSION_NKO                    => Yii::t('frontend', 'NKO'),
            self::PROFESSION_INTERNIST              => Yii::t('frontend', 'Internist'),
            self::PROFESSION_DOCTOR                 => Yii::t('frontend', 'Huisarts'),
            self::PROFESSION_NURSE                  => Yii::t('frontend', 'Verpleegkundige'),
            self::PROFESSION_PHYSIOTHERAPIST        => Yii::t('frontend', 'Kinesist'),
            self::PROFESSION_PHARMACIST             => Yii::t('frontend', 'Apotheker')
        ];
    }

    /**
     * Returns the countries
     *
     * @return  array
     */
    public static function countries()
    {
        return [
            self::COUNTRY_BE => Yii::t('frontend', 'Belgique'),
            self::COUNTRY_LU => Yii::t('frontend', 'Grand Duché du Luxembourg')
        ];
    }

    /**
     * Returns translated country name
     * 
     * @return string
     */
    public function getCountry() {
        return (isset(self::countries()[$this->country])) ? self::countries()[$this->country] : '';
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
            'riziv_number'                      => Yii::t('frontend', 'Riziv nummer'), // Enkel voor BE
            'doctorcode'                        => Yii::t('frontend', 'Arts nummer'), // Enkel voor LU
            'apb_number'                        => Yii::t('frontend', 'APB nummer'),
            'workplace_name'                    => Yii::t('frontend', 'Werkplaats'),
            'language'                          => Yii::t('frontend', 'Taal'),
            'country'                           => Yii::t('frontend', 'Land'),
            'address'                           => Yii::t('frontend', 'Adres'),
            'zipcode'                           => Yii::t('frontend', 'Postcode'),
            'city'                              => Yii::t('frontend', 'Gemeente'),
            'phone'                             => Yii::t('frontend', 'Telefoon'),
            'mobile'                            => Yii::t('frontend', 'GSM'),
            'responsible_pneumologist'          => Yii::t('frontend', 'Verantwoordelijke pneumoloog'),
            'workplace_type'                    => Yii::t('frontend', 'Werkplaats'),
            'registration_source'               => Yii::t('frontend', 'Registratie bron'),
        ]);
    }

    public function salutations()
    {
        return [
            self::SALUTATION_MR => Yii::t('frontend', 'Dhr.'),
            self::SALUTATION_MS => Yii::t('frontend', 'Mevr.')
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne('\infoweb\user\models\User', ['id' => 'user_id']);
    }
}