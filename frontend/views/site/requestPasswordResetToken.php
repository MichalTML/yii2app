<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

//$this->title = 'Request password reset';
//$this->params['breadcrumbs'][] = $this->title;
?>

   <?php $this->title = "Reset Password"; ?>

<div class="site-request-password-reset">
    

    <br />
    <br />
    <br />

    <div class="row">
        <div class="col-lg-4">
            <div class="well well-e well-login">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="login-logo "></div>
                    </div>
                </div>
                <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form',]); ?>
                    
           
                    
                    <?= $form->field($model, 'email', [
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
               'options' => [
                   'class' => 'col-sm-12'
                   ],
            'inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('email')
            ],
                    ]) ?>
                </div>
                     <p style="font-size: 12px; color: #88CD00;">*Please fill out your email. A link to reset password will be sent there.</p>
                
                <div class="row">
             <div class="col-sm-12">
                <?= Html::submitButton('Send', ['class' => 'btn btn-default login login-btn signup-btn']) ?>
             </div>
                </div>
                
               
                
                
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="login-helpers">           
                            <li><?= Html::a('Log in', ['site/login']) ?> </li>   
                            <li><?= Html::a('Sing up', ['site/singup'])?></li>   
                            <li><?= Html::a('Help', ['site/contact']) ?> </li>
                        </ul>
                        
                    </div>
                </div>
                
                   


                    
                   
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        <div class="col-lg-8"></div>
        </div>
    </div>

