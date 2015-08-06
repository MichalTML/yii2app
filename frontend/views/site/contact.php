<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Help';

?>
<div class ="site-help">
    <div class=""jumbotron">
   <br />

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="well well-e">
                    <h1><?= Html::encode( $this->title ) ?></h1>
                    <p>
                        If u have problems, question, you can use this form to contact system administrator.
                    </p>

                    <?php $form = ActiveForm::begin( ['id' => 'contact-form' ] ); ?>
                    <?= $form->field( $model, 'name' ) ?>
                    <?= $form->field( $model, 'email' ) ?>

                    <?= $form->field( $model, 'subject' )->dropDownList( $model->getSubjects(), ['prompt' => ' ']) ?>
                    <?= $form->field( $model, 'body' )->textArea( ['rows' => 6 ] ) ?>
                    <?=
                    $form->field( $model, 'verifyCode' )->widget( Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ] )
                    ?>
                    <div class="form-group">
                    <?= Html::submitButton( 'Submit', ['class' => 'btn btn-primary login', 'name' => 'contact-button' ] ) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-lg-3">
            </div>


        </div>
    </div>
</div>
