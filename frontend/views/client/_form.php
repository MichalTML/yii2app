<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clientNumber')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'fax')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'krs')->textInput() ?>

    <?= $form->field($model, 'regon')->textInput() ?>

    <?= $form->field($model, 'www')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creDate')->textInput() ?>

    <?= $form->field($model, 'updDate')->textInput() ?>

    <?= $form->field($model, 'creUserId')->textInput() ?>

    <?= $form->field($model, 'updUserId')->textInput() ?>

    <?= $form->field($model, 'contactId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
