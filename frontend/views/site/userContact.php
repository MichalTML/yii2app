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
    <div style="margin-top: 150px"></div>
    <div class=""jumbotron">
   <br />

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="well well-e well-login">
                    
                    

                    <?php $form = ActiveForm::begin( ['id' => 'contact-form' ] ); ?>

                    <?= $form->field( $model, 'subject' )->dropDownList( $model->getSubjects(), ['prompt' => ' ']) ?>
                    <?= $form->field( $model, 'body' )->textArea( ['rows' => 6 ] ) ?>
                    
                    <div class="form-group">
                    <?= Html::submitButton( 'Submit', ['class' => 'btn btn-primary login', 'name' => 'contact-button' ] ) ?>
                    </div>
                    <p style="font-size: 12px; color: #88CD00;">*Please fill out above form if u have any problems or questions.</p>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-lg-3">
            </div>


        </div>
    </div>
</div>
