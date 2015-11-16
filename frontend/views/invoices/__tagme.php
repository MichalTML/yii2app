<?php

use kartik\select2\Select2;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'pjax-group-form', 'timeout' => false, 'enablePushState' => false]);

    $config = ['template'=>"<span class='col-sm-10 group-creation'>{input}{error}</span>"];
    $form = ActiveForm::begin([
        'id' => 'login-form-horizontal', 
        'type' => ActiveForm::TYPE_INLINE,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);  
    ?>
    <div style="margin-bottom: 20px;">
    <?= $form->field($modelGroup, 'groupName', $config)->widget(LabelInPlace::classname(),[
            'label' => 'Group',
             ]);
    ?>
    <?= Html::submitButton('Create', ['class' => 'btn btn-success groupe-create group-button', 'title' => 'Create new group']); ?>
    </div>

    <?php
    echo Select2::widget([
        'name' => 'state_40',
        'data' => ['aaa', 'aaaa'],
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
Pjax::end();
