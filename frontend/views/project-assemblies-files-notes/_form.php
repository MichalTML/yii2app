<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesFilesNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-assemblies-files-notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fileId')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'typeId')->textInput() ?>

    <?= $form->field($model, 'creUserId')->textInput() ?>

    <?= $form->field($model, 'creTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
