<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-contacts-form">

   <?php
    $form = ActiveForm::begin(
                    [
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'formConfig' => ['showLabels' => false, 'labelSpan' => 2, 'showHints' => true],
                        'fullSpan' => 6,
                        
                    ]
    );
    ?>

    <?= $form->field($model, 'firstName', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('firstName')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastName', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('lastName')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genderId')->dropDownList($model->getGenderList(), ['prompt' => 'pick gender' ]) ?>

    <?= $form->field($model, 'phone', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('phone'). ' e.g. 555-444-332, 23 232-32-23'
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('fax')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('email')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('department')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('position')
            ]
            ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('description')
            ]
            ])->textInput(['maxlength' => true]) ?>

   <br />
        <?= Html::submitButton( 'Create', ['class' => 'btn btn-success', 'name' => 'create']) ?>
   
        <?= Html::submitButton( 'Add another', ['class' => 'btn btn-primary', 'name' => 'add']) ?>
   
    <?php ActiveForm::end(); ?>

</div>
