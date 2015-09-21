<?php

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectMainFilesNotes */
?>
 <?= GridView::widget([
     'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{pager}",
        'rowOptions' => ['style' => 'text-align: center;'],
        'showHeader' => false,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'emptyText' => '<span style="text-align:center">No Notes found</span>', 
        'emptyTextOptions' => ['style' => 'text-align:center;'],
        'columns' => [
            [
                'value' => 'type.type',
                'label' => 'typeId',
                'contentOptions' => ['style' => 'width:50px;']
                
            ],
[
                'value' => 'note',
                'label' => 'Note Content',
                'contentOptions' => ['style' => 'width:400px']
                
            ],
            [
                'value' => 'creUser.username',
                'label' => 'Created by',
                'contentOptions' => ['style' => 'width:50px']
                
            ],
            [
                'value' => 'creTime',
                'label' => 'Created at',
                'contentOptions' => ['style' => 'width:50px; white-space: nowrap;']
                
            ],
           
            
            
        ]
]);
?>