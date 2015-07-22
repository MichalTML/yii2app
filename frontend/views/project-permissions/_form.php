<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectPermissions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-permissions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'projectId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userId')->textInput() ?>

    <?= $form->field($model, 'create')->textInput() ?>

    <?= $form->field($model, 'edit')->textInput() ?>

    <?= $form->field($model, 'view')->textInput() ?>

    <?= $form->field($model, 'delete')->textInput() ?>

    <?= $form->field($model, 'creTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
