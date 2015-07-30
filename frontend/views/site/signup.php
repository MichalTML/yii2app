<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode( $this->title ) ?></h1>



    <div class="row">
        <div class="col-lg-5">
            <?php
            $form = ActiveForm::begin(
                            [
                                'type' => ActiveForm::TYPE_HORIZONTAL,
                                'formConfig' => ['showLabels' => false, 'labelSpan' => 2, 'showHints' => true ],
                                'fullSpan' => 6,
                            ]
            );
            ?>



            <?=
            $form->field( $model, 'username', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'username' )
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
            
            <?=
            $form->field( $model, 'email', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'email' )
                ]
            ] )->textInput()
            ?>

            <?=
            $form->field( $model, 'password', ['inputOptions' =>
                [
                    'placeholder' => $model->getAttributeLabel( 'password' )
                ]
            ] )->passwordInput()
            ?>

            <br />

<?= Html::submitButton( 'Signup', ['class' => 'btn btn-default login', 'name' => 'signup-button' ] ) ?>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
