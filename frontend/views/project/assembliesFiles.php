<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\models\ProjectAssembliesData;
use frontend\models\FileStatus;
use frontend\models\ProjectAssembliesFilesTypes;
use frontend\models\FilePriority;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="project-data-index">
    <?php Pjax::begin(['id' => 'pjax-data-assemblies-files']); ?>
    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'summary' => "",
        'rowOptions' => ['style' => 'font-size:12px'],
        'headerRowOptions' => ['style' => 'font-size:12px'],
        'filterRowOptions' => ['style' => 'max-height: 10px'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; vertical-align:middle;'],
            ],
           [
               'label' => 'File Name',
               'attribute' => 'name',
               'value' => 'name',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
            [
               'label' => 'Assemblie',
               'attribute' => 'assemblie.name',
               'filter' => Html::activeDropDownList($searchModel, 'assemblie.name', 
                           ArrayHelper::map(ProjectAssembliesData::find()
                           ->where( ['projectId' => $sygnature])->asArray()->all(), 
                           'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'assemblie.name',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
           [
               'label' => 'Status',
               'attribute' => 'status.statusName',
               'filter' => Html::activeDropDownList($searchModel, 'status.statusName', 
                           ArrayHelper::map(FileStatus::find()->asArray()->all(), 'statusName','statusName'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'status.statusName',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
            [
               'label' => 'Type',
               'attribute' => 'type.name',
               'filter' => Html::activeDropDownList($searchModel, 'type.name', 
                           ArrayHelper::map(  ProjectAssembliesFilesTypes::find()->asArray()->all(), 'name','name'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'type.name',
               'headerOptions' => ['style' => 'text-align: center; width: 170px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
            [
               'label' => 'Priority',
               'attribute' => 'priority.name',
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', ArrayHelper::map( FilePriority::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'priority.name',
               'headerOptions' => ['style' => 'text-align: center; width: 70px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
           [
               'label' => 'Ext.',
               'attribute' => 'ext',
               'value' => 'ext',
               'headerOptions' => ['style' => 'text-align: center;width: 70px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
            [
               'label' => 'Quanity',
               'attribute' => 'quanity',
               'value' => 'quanity',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
           [
               'label' => 'Finished',
               'attribute' => 'quanityDone',
               'value' => 'quanityDone',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;' ],
           ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;' ],
                                'template' => '{download} {view}',
                                'buttons' => [                                            
                                            'download' => function($url, $model)
                                    {
                                        return Html::a( '<span class="fa fa-download"></span>', $url, [
                                                    'data-method' => 'post',
                                                    'title' => Yii::t( 'app', 'download' ),
                                                ] );
                                    },
                                    
                                            'view' => function($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="glyphicon glyphicon-eye-open"></i></a>', 
                                               ['value' => $url, 'class' => 'file-details-a', 'id' => 'file-details-a', 
                                                'file-name' => $model->name, 'title' => 'file details' ] );
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) use ($id) 
                                {
                                    if ( $action === 'delete' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/delete', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'download' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $model->path, 
                                               'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                } 
                                
                                    ],
            ]
        ]);
                                    
$this->registerJS("    
    // View File Details
    $('.file-details-a').click(function(){
        action = $(this).attr('id');
        var fileName = $(this).attr('file-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('File: ' + fileName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
");
        Pjax::end();


