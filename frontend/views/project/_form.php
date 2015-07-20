<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

//use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'clientId', $options = ['options' => ['style' => 'display: inline;'],] )->dropDownList( $model->getClientList(), ['prompt' => 'Choose client' ] ) ?>  

    <?= Html::a( 'Add client', ['client/add' ],['class' => 'btn btn-default', 'style' => 'margin-bottom: 30px;']); ?>

    

    <?= $form->field( $model, 'projectId' )->textInput( ['maxlength' => true ] ) ?>

    <?= $form->field( $model, 'projectName' )->textInput( ['maxlength' => true ] ) ?>

    <?=
    $form->field( $model, 'deadline' )->widget( DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'yearRange' => '-115:+0',
            'changeYear' => true ]
    ] )
    ?>  

    <?= $form->field( $model, 'projectStatus' )->dropDownList( $model->getStatusList(), ['prompt' => 'Choose project status' ] ) ?>   


    <?=
    $form->field( $model, 'constructorId', ['template' => "{label}<span class='checkbox'>{input}</span>" ] )->checkboxList( $model->getConstructorList(), $options = [
        'separator' => '<br />'
            ]
    );
    ?>



    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
