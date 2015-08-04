<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Profile;
use common\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PermissionHelpers;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup' ],
                'rules' => [
                    [
                        'actions' => ['signup' ],
                        'allow' => true,
                        'roles' => ['?' ],
                    ],
                    [
                        'actions' => ['logout' ],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post' ],
                ],
            ],
        ];
    }
   
    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $this->layout = 'menu';
        if ( Yii::$app->user->isGuest )
        {
            return $this->render( 'index' );
        }
        return $this->render( 'main' );
    }

    public function actionMain() {
        $this->layout = 'menu';
        return $this->render( 'main' );
    }

    public function actionClients() {
        $this->layout = 'menu';
        return $this->render( 'clients' );
    }

    public function actionOtherClients() {
        $this->layout = 'menu';
        return $this->render( 'otherClients' );
    }

    public function actionLogin() {
        $this->layout = 'action';
        if ( !\Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->login() )
        {
            return $this->redirect( ['main' ] );
        } else
        {
            return $this->render( 'login', [
                        'model' => $model,
            ] );
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $this->layout = 'action';
        $model = new ContactForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->validate() )
        {
            if ( $model->sendEmail( Yii::$app->params[ 'adminEmail' ] ) )
            {
                Yii::$app->session->setFlash( 'success', 'Thank you for contacting us. We will respond to you as soon as possible.' );
            } else
            {
                Yii::$app->session->setFlash( 'error', 'There was an error sending email.' );
            }

            return $this->refresh();
        } else
        {
            return $this->render( 'contact', [
                        'model' => $model,
            ] );
        }
    }

    public function actionAbout() {
        $this->layout = 'action';
        return $this->render( 'about' );
    }

    public function actionSignup() {
        $this->layout = 'action';
        $profile = new Profile();
        $model = new SignupForm();
        $userm = new User;

        if ( $model->load( Yii::$app->request->post() )
                && $profile->load( Yii::$app->request->post() ) )
        {
            if ( $user = $model->signup() )
            {
                $userId = $user->find()->where( ['email' => $model->email ] )->one();
                $profile->userId = $userId->id;

                if ( Yii::$app->getUser()->login( $user ) && $profile->save() )
                {
                    $this->signUpInfo($userId->username, $profile->firstName, $profile->lastName);
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render( 'signup', [
                    'model' => $model,
                    'profile' => $profile,
        ] );
    }
    
    public function signUpInfo($user, $name, $surname)
    {
        $adminEmail = 'michal.kungonda@telemobile.pl';
        Yii::$app->mailer->compose(['html' => 'userRegistration-html' , 'text' => 'userRegistration-txt'], ['user' => $user])
            ->setFrom('yii2app@TMA-AUTOMATION.pl')
            ->setTo($adminEmail)
            ->setSubject('User: ' . $user . ' just signed up!')
            ->send();
           
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->validate() )
        {
            if ( $model->sendEmail() )
            {
                Yii::$app->getSession()->setFlash( 'success', 'Check your email for further instructions.' );

                return $this->goHome();
            } else
            {
                Yii::$app->getSession()->setFlash( 'error', 'Sorry, we are unable to reset password for email provided.' );
            }
        }

        return $this->render( 'requestPasswordResetToken', [
                    'model' => $model,
        ] );
    }

    public function actionResetPassword( $token ) {
        try {
            $model = new ResetPasswordForm( $token );
        } catch ( InvalidParamException $e ) {
            throw new BadRequestHttpException( $e->getMessage() );
        }

        if ( $model->load( Yii::$app->request->post() ) && $model->validate() && $model->resetPassword() )
        {
            Yii::$app->getSession()->setFlash( 'success', 'New password was saved.' );

            return $this->goHome();
        }

        return $this->render( 'resetPassword', [
                    'model' => $model,
        ] );
    }

    public function getImageUrl() {
        return Url::to( 'http://www.tma-automation.com/wp-content/themes/TM-Automation/images/logo.jpg' . $this->logo, true );
    }

}
