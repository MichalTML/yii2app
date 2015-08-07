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
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            
            <div class="well well-e">
               <h1><?= Html::encode( $this->title ) ?></h1> 
                <p>Your sign up will be reviewed by admin.</p>
                <br />
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

            <br />

<?= Html::submitButton( 'Signup', ['class' => 'btn btn-default login', 'name' => 'signup-button' ] ) ?>

<?php ActiveForm::end(); ?>
        </div>
    </div>
        <div class="col-lg-4"></div>
</div>
</div>
