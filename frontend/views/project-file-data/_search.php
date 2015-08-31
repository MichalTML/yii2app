<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectFileDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-file-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'projectId') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'root') ?>

    <?= $form->field($model, 'files') ?>

    <?= $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'assembliesMainFiles') ?>

    <?php // echo $form->field($model, 'projectMainFiles') ?>

    <?php // echo $form->field($model, 'assembliesFiles') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
