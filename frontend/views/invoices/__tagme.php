<?php

use kartik\select2\Select2;
use yii\widgets\Pjax;

Pjax::begin();
echo Select2::widget([
    'name' => 'state_40',
    'data' => ['aaa', 'aaaa'],
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
Pjax::end();
