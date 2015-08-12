<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */
?>
<div class="site-reset-password">


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
                    <?php $form = ActiveForm::begin( ['id' => 'reset-password-form' ] ); ?>
                    
                        

                    <?=
                    $form->field( $model, 'password', [
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'options' => [
                            'class' => 'col-sm-12'
                        ],
                        'inputOptions' =>
                        [
                            'placeholder' => $model->getAttributeLabel( 'password' )
                        ],
                    ] )->passwordInput()
                    ?>
                    
                    <?=
                    $form->field( $model, 'passwordRepeat', [
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'options' => [
                            'class' => 'col-sm-12'
                        ],
                        'inputOptions' =>
                        [
                            'placeholder' => $model->getAttributeLabel( 'passwordRepeat' )
                        ],
                    ] )->passwordInput()
                    ?>
                   
                    
                </div>
                <p style="font-size: 12px; color: #808080;">*Please choose your new password.</p>

                <div class="row">
                    <div class="col-sm-12">
<?= Html::submitButton( 'Save', ['class' => 'btn btn-default login login-btn signup-btn' ] ) ?>
                    </div>
                </div>
                
<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
              







