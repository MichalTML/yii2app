<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'clientNumber') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'abr') ?>

    <?= $form->field($model, 'adress') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'krs') ?>

    <?php // echo $form->field($model, 'regon') ?>

    <?php // echo $form->field($model, 'www') ?>

    <?php // echo $form->field($model, 'creDate') ?>

    <?php // echo $form->field($model, 'updDate') ?>

    <?php // echo $form->field($model, 'creUserId') ?>

    <?php // echo $form->field($model, 'updUserId') ?>

    <?php // echo $form->field($model, 'contactId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
