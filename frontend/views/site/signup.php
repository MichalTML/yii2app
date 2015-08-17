<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Sign up';
?>
<div class="site-signup">
 <br />
 <br />
    <div class="row">
        
        <div class="col-lg-4">
           
            <div class="well well-e well-login">
                 <div class="col-sm-12">
                        <div class="login-logo "></div>
                    </div> 

            <?php
            $form = ActiveForm::begin(
            );
            ?>
                
            <?=
            $form->field( $model, 'email', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'email' )
                ]
            ] )->textInput()
            ?>
                
            <?=
            $form->field( $profile, 'firstName', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'first name' )
                ]
            ] )->textInput()
            ?>
            
            <?=
            $form->field( $profile, 'lastName', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'last name' )
                ]
            ] )->textInput()
            ?>
            
            <br />

            <?=
            $form->field( $model, 'password', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'password' )
                ]
            ] )->passwordInput()
            ?>
                
            <?=
            $form->field( $model, 'passwordRepeat', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'passwordRepeat' )
                ]
            ] )->passwordInput()
            ?>
            <div class="row">
             <div class="col-sm-12">
                <?= Html::submitButton( 'Sign up', ['class' => 'btn btn-default login login-btn signup-btn', 'name' => 'signup'] ); ?>
             </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="login-helpers">           
                            <li><?= Html::a('Log in', ['site/login']) ?> </li>   
                            <li><?= Html::a('Forgot Password?', ['site/request-password-reset'])?></li>   
                            <li><?= Html::a('Help', ['site/contact']) ?> </li>
                        </ul>
                        
                    </div>
                </div>


<?php ActiveForm::end(); ?>
        </div>
    </div>
        <div class="col-lg-8"></div>
</div>
</div>
