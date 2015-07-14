<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Profile;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProfileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'id') ?>

    <?php //$form->field($model, 'user_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'birthdate') ?>
    
    <?= $form->field($model, 'gender_id')->dropDownList(Profile::getGenderList(),
            ['prompt' => 'Please Choose One']);?>

    <?php // echo $form->field($model, 'gender_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
