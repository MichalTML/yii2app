<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Profile;
use common\models\PermissionHelpers;
use common\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
            return $this->redirect(['site/login']);
        }
       return $this->redirect(['site/main']);
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

    public function actionLogin($flag = null, $sygnature = null, $projectId = null, $elementName = null) {
        $this->layout = 'login';
        if ( !\Yii::$app->user->isGuest )
        {
            return $this->redirect( ['site/main']);
        }

        $model = new LoginForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->login() )
        {
            if($flag == 1){
                return $this->redirect( ['invoices/index' ] );   
            }elseif($flag == 2){
                return $this->redirect( ['invoices/index' ] );  
            }
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
        
        $model = new ContactForm();
        
        if(\Yii::$app->user->isGuest == false){
               
                
                $userEmail = Yii::$app->user->identity->email;
                $userName = Yii::$app->user->identity->username;
            
                $model->email = $userEmail;
                $model->name = $userName;
            } else {
                $model->scenario = 'captcha';
            }
        
        if ( $model->load( Yii::$app->request->post() ) && $model->validate() )
        {
            
            if ( $model->sendEmail('michal.kungonda@telemobile.pl') )
            {
                Yii::$app->session->setFlash( 'success', 'We will respond to you as soon as possible.' );
                return $this->redirect(['main']);
            } else
            {
                Yii::$app->session->setFlash( 'error', 'There was an error sending email.' );
            }

            return $this->refresh();
        } else
        {
            if(Yii::$app->user->isGuest){
                $this->layout = 'login'; 
            return $this->render( 'contact', [
                        'model' => $model,
            ] );
            } else {
                $this->layout = 'menu'; 
                return $this->render( 'userContact', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionAbout() {
        $this->layout = 'action';
        return $this->render( 'about' );
    }

    public function actionSignup() {
        $this->layout = 'login';
        $profile = new Profile();
        $model = new SignupForm();
        $user = new User;

        if ( $model->load( Yii::$app->request->post())
                && $profile->load( Yii::$app->request->post() ) )            
        { 
            
            if ( $user = $model->signup() )
            {
                $userId = $user->find()->where( ['email' => $model->email ] )->one();
                $profile->userId = $userId->id;

                if ( $profile->save() )
                {
                    $this->signUpInfo($userId->username, $userId->id);
                    Yii::$app->getSession()->setFlash( 'info', 'Your account credentials are being reviewed by admin.' );
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render( 'signup', [
                    'model' => $model,
                    'profile' => $profile,
        ] );
    }
    
    public function signUpInfo($userName, $userId)
    {
        $user = User::findOne([
            'id' => $userId,
        ]);
        
        $adminEmail = 'michal.kungonda@telemobile.pl';
        Yii::$app->mailer->compose(['html' => 'userRegistration-html' , 'text' => 'userRegistration-txt'], ['user' => $user])
            ->setFrom('yii2app@TMA-AUTOMATION.pl')
            ->setTo($adminEmail)
            ->setSubject('User: ' . $userName . ' just signed up!')
            ->send();
           
    }

    public function actionRequestPasswordReset() {
        $this->layout = "login";
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
        $this->layout = "login";
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
    
//    public function actionAdministration() {
//        return $this->redirect(Yii::$app->urlManagerBackend->createUrl('index.php?r=site/index'));  
//    }
    
    public function actionAdministration() {
        
        if(PermissionHelpers::requireRole('Admin')){
            $this->layout = 'menu';
            return $this->redirect(['user/index']);
        } else {
            Yii::$app->getSession()->setFlash( 'error', 'You don`t have administration rights.');
            return $this->redirect(['site/main']);
        }
    }
    
    public function actionOptions() {
        $this->layout = 'menu';
        return $this->render('options');
    }

}
