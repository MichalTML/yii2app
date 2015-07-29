<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\OClientDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oclient-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'statusId') ?>

    <?= $form->field($model, 'clientNumber') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'abr') ?>

    <?php // echo $form->field($model, 'adress') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'postal') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'krs') ?>

    <?php // echo $form->field($model, 'regon') ?>

    <?php // echo $form->field($model, 'www') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'creTime') ?>

    <?php // echo $form->field($model, 'creUserId') ?>

    <?php // echo $form->field($model, 'updTime') ?>

    <?php // echo $form->field($model, 'updUserId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
