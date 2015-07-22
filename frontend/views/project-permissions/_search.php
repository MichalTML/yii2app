<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectPermissionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-permissions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'projectId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'create') ?>

    <?= $form->field($model, 'edit') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'delete') ?>

    <?php // echo $form->field($model, 'creTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
