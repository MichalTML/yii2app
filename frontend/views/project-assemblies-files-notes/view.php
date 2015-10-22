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
                'contentOptions' => ['style' => 'width:150px; font-size: 10px; vertical-align: middle; font-weight: bold']
                
            ],
[
                'value' => 'note',
                'label' => 'Note Content',
                'contentOptions' => ['style' => 'word-wrap: break-word; overflow: hidden; max-width:400px; font-size: 14px; vertical-align: middle;']
                
            ],
            [
                'value' => 'creUser.username',
                'label' => 'Created by',
                'contentOptions' => ['style' => 'color: #87cd00; width:60px; font-size: 10px; vertical-align: middle;']
                
            ],
            [
                'value' => 'creTime',
                'label' => 'Created at',
                'contentOptions' => ['style' => 'width:50px; white-space: nowrap; font-size: 10px; vertical-align: middle;']
                
            ],
           
            
            
        ]
]);
?>