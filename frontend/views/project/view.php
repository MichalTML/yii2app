<?php

use yii\widgets\DetailView;

?>

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sygnature',
            'projectName',            
            'deadline',
            'projectStatus0.statusName',
            'client.name', 
            'creUser.username',
            'projectPermissionsUsers',
            'creTime',            
            'updUser.username',
            'updTime',                 
            'endTime',            
        ],
    ]) ?>

