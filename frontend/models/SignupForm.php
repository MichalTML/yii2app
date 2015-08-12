<?php
namespace frontend\models;

use common\models\User;
use frontend\models\Profile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'match', 'pattern' => '/^[a-z]*\.{1}[a-z]*@[a-z-]*\.[plcom]{2,3}$/', 'message' => 'Check if your email is correct, example: name.surname@tma-automation.pl'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Password doesn`t match'],
            ['password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-zA-Z])([a-zA-Z0-9]+){7,}$/', 'message' => 'Alphanumeric only allowed. One capital, number and at least 7 chars required.'],
            ['passwordRepeat', 'safe'],
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
            $user->username = $this->setUsername($this->email);
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
    
    /**
     * Generating new user name from email data.dat format from xxxx.xxxxx@xxxxx.xx
     * @param type $email
     * @return string
     */
    private function setUsername($email) {
        
    $login = preg_filter('/@{1}.*$/', '', $email);
    $login = explode('.', $login);
    $login = ucfirst($login[0]) . '.' . ucfirst(substr($login[1], 0, 3));
    
    return $login;
    }
}
