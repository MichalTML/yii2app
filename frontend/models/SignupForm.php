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
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Password doesn`t match'],
            ['password', 'string', 'min' => 6],
            ['passwordRepeat', 'safe']
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
