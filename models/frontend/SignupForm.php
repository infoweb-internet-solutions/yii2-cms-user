<?php
namespace infoweb\user\models\frontend;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use infoweb\user\models\Profile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $firstname;
    public $name;
    public $language;   
    public $address;
    public $city;
    public $zipcode;
    public $phone;
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'firstname', 'email', 'username', 'password'], 'required'],
            [['name', 'firstname', 'email', 'address', 'zipcode', 'city', 'phone', 'mobile', 'username'], 'trim'],
            ['language', 'string', 'max' => 2],
            ['language', 'default', 'value' => Yii::$app->language],
            // Username has to be unique
            ['username', 'unique', 'targetClass' => 'infoweb\user\models\frontend\User', 'message' => Yii::t('infoweb/user', 'This username has already been taken.')],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            // Emailaddress has to be unique
            ['email', 'unique', 'targetClass' => 'infoweb\user\models\frontend\User', 'message' => Yii::t('infoweb/user', 'This email address has already been taken.')],
            // Passwords must match
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],           
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
            
            $transaction = Yii::$app->db->beginTransaction();
            
            // Create the user
            $user = new User([
                'username'          => $this->username,
                'email'             => $this->email,
                'password_hash'     => Yii::$app->security->generatePasswordHash($this->password),
                'auth_key'          => Yii::$app->security->generateRandomString(),
                'scope'             => User::SCOPE_FRONTEND,
                'confirmed_at'      => time()
            ]);
            
            if ($user->save()) {
                
                // Create the profile
                $profile = new Profile([
                    'user_id'                       => $user->id,
                    'name'                          => $this->name,
                    'public_email'                  => $this->email,
                    'firstname'                     => $this->firstname,                    
                    'address'                       => $this->address,
                    'city'                          => $this->city,
                    'zipcode'                       => $this->zipcode,
                    'phone'                         => $this->phone,
                    'mobile'                        => $this->mobile,                    
                    'language'                      => $this->language
                ]);
                
                if ($profile->save(false)) {
                    $transaction->commit();
                    return $user;
                }                                    
            }            
        }

        return null;
    }
}
