<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use common\models\PermissionHelpers;
use frontend\models\UserAttendance;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $email;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean' ],
            // password is validated by validatePassword()
            ['password', 'validatePassword' ],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword( $attribute, $params ) {
        if ( !$this->hasErrors() ) {
            $user = $this->getUser();
            
            if ( !$user || !$user->validatePassword( $this->password ) ) {
                $this->addError('email');
                $this->addError( $attribute, 'Incorrect email or password.' );
            } elseif($user->status_id !== 1){
                Yii::$app->getSession()->setFlash( 'error', 'Your account credentials are being reviewed by admin.' );
                $this->addError( $attribute, '' );
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
        if ( $this->validate() ) {
            $user = $this->getUser();
            $user->last_log = date('d.m.Y');
            $UserAtt = new UserAttendance;
            $UserAtt->stampAttendance($user->id);
            if($user->save()){
            return Yii::$app->user->login( $this->getUser(), $this->rememberMe ? 3600 : 0 );
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser() {
        if ( $this->_user === false ) {
            $this->_user = User::findByEmail( $this->email );     
        }
        return $this->_user;
    }
    
//    // personal metod working!
//    public function loginAdmin() {
//
//        if (($this->validate()) && ValueHelpers::getUsersRoleName($this->getUser()->id) == 'Admin'){
//            return Yii::$app->user->login( $this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0 );
//        } else {
//
//            throw new NotfoundHttpException( 'You Shall Not Pass.'/*.$this->getUser()->id*/);
//        }
//    }
    
    public function loginAdmin() {
        if(($this->validate()) && PermissionHelpers::requireMinimumRole('SuperUser', $this->getUser()->id)) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            throw new NotFoundHttpException('You Shall Not Pass.');
        }
    }

}
