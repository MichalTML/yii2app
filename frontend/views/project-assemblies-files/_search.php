<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ProjectAssembliesFilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-assemblies-files-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'projectId') ?>

    <?= $form->field($model, 'assemblieId') ?>

    <?= $form->field($model, 'typeId') ?>

    <?= $form->field($model, 'sygnature') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'ext') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'thickness') ?>

    <?php // echo $form->field($model, 'quanity') ?>

    <?php // echo $form->field($model, 'material') ?>

    <?php // echo $form->field($model, 'quanityDone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'feedback') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
