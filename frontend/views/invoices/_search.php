<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\InvoicesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoices-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'supplierId') ?>

    <?= $form->field($model, 'connection') ?>

    <?= $form->field($model, 'isAccepted') ?>

    <?php // echo $form->field($model, 'ext') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'acceptedBy') ?>

    <?php // echo $form->field($model, 'creTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
