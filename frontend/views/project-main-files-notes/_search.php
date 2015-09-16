<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectMainFilesNotesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-main-files-notes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fileId') ?>

    <?= $form->field($model, 'note') ?>

    <?= $form->field($model, 'typeId') ?>

    <?= $form->field($model, 'creUserId') ?>

    <?php // echo $form->field($model, 'creTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
