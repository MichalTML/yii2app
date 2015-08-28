<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectNotesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-notes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'projectId') ?>

    <?= $form->field($model, 'note') ?>

    <?= $form->field($model, 'creUserId') ?>

    <?= $form->field($model, 'creTime') ?>

    <?php // echo $form->field($model, 'updTime') ?>

    <?php // echo $form->field($model, 'updUserId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
