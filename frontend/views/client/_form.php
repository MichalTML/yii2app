<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-data-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'formConfig' => ['showLabels' => false, 'labelSpan' => 2, 'showHints' => true],
                        'fullSpan' => 6,
                        
                    ]
    );
    ?>

    <?= $form->field( $model, 'name', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('name')
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'abr', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('abr')
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'adress', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('adres').' e.g. Jagielońska 23/3'
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>
    
    <?= $form->field( $model, 'city', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('city')
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>
    
    <?= $form->field( $model, 'postal', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('postal').' e.g. 80-198'
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'phone', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('phone'). ' e.g. 555-444-332, 23 232-32-23'
            ]
            ] )->textInput() ?>

    <?= $form->field( $model, 'fax', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('fax')
            ]
            ] )->textInput() ?>

    <?= $form->field( $model, 'email', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('email')
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'nip', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('nip'). ' e.g. 1234567890'
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'krs', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('krs'). ' e.g. 0000282198'
            ]
            ] )->textInput() ?>

    <?= $form->field( $model, 'regon', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('regon'). ' e.g. 123456785'
            ]
            ] )->textInput() ?>

<?= $form->field( $model, 'www', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('www')
            ]
            ] )->textInput( ['maxlength' => true ] ) ?>
    
    <?= $form->field( $model, 'description', ['inputOptions' => 
            [
            'placeholder' => $model->getAttributeLabel('description'). ' e.g. Additional information about the client that might prove useful.'
            ]
            ] )->textarea() ?>
<br />
    <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    <?= Html::submitButton( 'Add contact' , ['class' => 'btn btn-success']); ?>

<?php ActiveForm::end(); ?>

</div>
