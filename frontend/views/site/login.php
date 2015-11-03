<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>
<div class="site-login">
    

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
            <?php $form = ActiveForm::begin(['id' => 'login-form',]); ?>
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
                
                <div class="row">
                <?= $form->field($model, 'password', [
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
               'options' => [
                   'class' => 'col-sm-12'
                   ],
            'inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('password')
            ],
                    ])->passwordInput() ?>
                
                </div>
                <div class="row">
                <?= $form->field($model, 'rememberMe', [
                    'template' => '{beginWrapper}{input}{endWrapper}',
                    'options' => [
                    'class' => 'col-xs-6',
                   ],
                ])->checkbox() ?>
                
                <div class="form-group col-xs-6">
                <?= Html::submitButton( 'Login', ['class' => 'login login-btn btn btn-primary', 'name' => 'login-button'] ); ?>
                </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="login-helpers">           
                            <li><?= Html::a('Sign Up', ['site/signup']) ?> </li>   
                            <li><?= Html::a('Forgot Password?', ['site/request-password-reset'])?></li>   
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
</div>
