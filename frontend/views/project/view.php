<?php

use yii\widgets\DetailView;
use frontend\models\ProjectData;

?>

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sygnature',
            'projectName',  
            'projectStatus0.statusName',
            'client.name', 
            'projectPermissionsUsers',
            'projectStart',
            [
                'attribute' => 'deadline',               
                'label' => 'Durations (weeks)',
                'value' => ProjectData::getProjectDuration($id),
            ],
            'deadline',
            'endTime', 
            'creUser.username',
            'creTime',            
            'updUser.username',
            'updTime',                                
        ],
    ]) ?>

