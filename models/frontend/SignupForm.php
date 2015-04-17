<?php
namespace infoweb\user\models\frontend;

use Yii;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $salutation;
    public $firstname;
    public $name;
    public $profession;
    public $workplace_type;
    public $workplace_name;
    public $address;
    public $city;
    public $zipcode;
    public $phone;
    public $mobile;
    public $riziv_number;
    public $apb_number;
    public $order_of_pharmacists_number;
    public $responsible_pneumologist;
    public $agree_user_terms;
    public $read_privacy_policy;
    public $profession_declaration;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salutation', 'name', 'firstname', 'email', 'address', 'profession', 'username', 'password', 'agree_user_terms', 'read_privacy_policy', 'profession_declaration'], 'required'],
            [['name', 'firstname', 'email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'username', 'workplace_name', 'responsible_pneumologist'], 'trim'],
            // Username has to be unique
            ['username', 'unique', 'targetClass' => 'infoweb\models\frontend\User', 'message' => Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            // Emailaddress has to be unique
            ['email', 'unique', 'targetClass' => 'infoweb\models\frontend\User', 'message' => Yii::t('app', 'This email address has already been taken.')],
            [['agree_user_terms', 'read_privacy_policy', 'profession_declaration'], 'compare', 'compareValue' => 1],
            // The password must contain at least one number and one symbol
            ['password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[@#$%^&*])[A-Za-z0-9@#$%^&*]{6,}$/'],
            // Passwords must match
            ['password', 'compare'],
            // Nurses and pneumologists must have a specific workplace_type
            ['workplace_type', 'in', 'range' => [User::WORKPLACETYPE_HOSPITAL, User::WORKPLACETYPE_PRIVATE], 'when' => function($model) {
                return in_array($model->profession, [User::PROFESSION_PNEUMOLOGIST, User::PROFESSION_NURSE]);
            }],
            // Nurses and pneumologists must have a workplace_name
            ['workplace_name', 'required', 'when' => function($model) {
                return in_array($model->profession, [User::PROFESSION_PNEUMOLOGIST, User::PROFESSION_NURSE]);
            }],
            // Pharmacists need an APB number
            ['apb_number', 'required', 'when' => function($model) {
                return $model->profession == User::PROFESSION_PHARMACIST;
            }],
            // All the rest needs a riziv number
            ['riziv_number', 'required', 'when' => function($model) {
                return !in_array($model->profession, [User::PROFESSION_PHARMACIST, '']);
            }]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'                          => Yii::t('user', 'Username'),
            'email'                             => Yii::t('user', 'Email'),
            'password'                          => Yii::t('user', 'Password'),
            'password_repeat'                   => Yii::t('infoweb/user', 'Repeat password'),
            'salutation'                        => Yii::t('infoweb/user', 'Salutation'),
            'firstname'                         => Yii::t('infoweb/user', 'Firstname'),
            'name'                              => Yii::t('infoweb/user', 'Name'),
            'profession'                        => Yii::t('infoweb/user', 'Profession'),
            'workplace_type'                    => Yii::t('infoweb/user', 'Workplace'),
            'riziv_number'                      => Yii::t('infoweb/user', 'Riziv number'),
            'apb_number'                        => Yii::t('infoweb/user', 'APB number'),
            'agree_user_terms'                  => Yii::t('infoweb/user', 'I agree with the user-terms'),
            'read_privacy_policy'               => Yii::t('infoweb/user', 'I have read the privacy policy'),
            'profession_declaration'            => Yii::t('infoweb/user', 'I declare to be a registered doctor, nurse or pharmacist'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
