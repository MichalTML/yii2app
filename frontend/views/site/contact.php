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
            <?php $form = ActiveForm::begin( ['id' => 'contact-form' ] ); ?>
                    
           <?= $form->field($model, 'name', [
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
               'options' => [
                   'class' => 'col-sm-12'
                   ],
            'inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('name')
            ],
                    ]) ?>
                    
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
                    
                     <?= $form->field( $model, 'subject', [
                         'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'options' => [
                        'class' => 'col-sm-12'
                        ],
                        'inputOptions' => 
                        [
                        'placeholder' => $model->getAttributeLabel('subject')
                       ],])->dropDownList( $model->getSubjects(), [
                         'prompt' => '',
                          ]) ?>
                    
                    
                     <?= $form->field( $model, 'body', [
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
               'options' => [
                   'class' => 'col-sm-12'
                   ],
            'inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('Put your message here......')
            ],])->textArea( ['rows' => 6 ] ) ?>
                  </div> 
                   <div class="row"> 
                    <?=
                    $form->field( $model, 'verifyCode',
                            [
                                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                                'options' => [
                                    'class' => 'col-sm-12'
                                    ],
                                'inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('')
            ],])->widget( Captcha::className(), [
                        'template' => '{image}<div style="max-width: 200px; float: right;">{input}</div>',
                    ] )
                    ?>
                   </div>
            
                    
                <div class="row">
             <div class="col-sm-12">
              <?= Html::submitButton( 'Send', ['class' => 'btn btn-default login login-btn signup-btn', 'name' => 'contact-button' ] ) ?>
             </div>
                </div>
                
               
                
                
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="login-helpers">           
                            <li><?= Html::a('Log in', ['site/login']) ?> </li>   
                            <li><?= Html::a('Forgot Password?', ['site/request-password-reset'])?></li>   
                            <li><?= Html::a('sing up', ['site/singup']) ?> </li>
                        </ul>
                        
                    </div>
                </div>
                
                   


                    
                   
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        <div class="col-lg-8"></div>
        </div>
    </div>
