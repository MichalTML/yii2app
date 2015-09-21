<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\models\search\ProjectSearch;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use frontend\models\ProjectNotes;
use frontend\models\ProjectFileData;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects list';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>

<div class="project-data-index">

    <?php Pjax::begin(); ?>

    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'rowOptions' => function ($model)
                                    {
                                        $filesSearch = ProjectFileData::find()->where(['projectId' => $model->sygnature])->one();
                                        if(isset($filesSearch->projectId)){
                                            
                                        return ["style" => "background-color:#e6e6e6; "];
                                        
                                        
                                        } else {
                                            
                                            return ["style" => "border-color:white;"];
                                    }},
                'columns' => [
                    [
                        'label' => 'Sygnature',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'sygnature',
                        'value' => 'sygnature',
                        'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;' ],
                    ],
                    [
                        'label' => 'Project Name',
                        'attribute' => 'projectName',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em; white-space: nowrap;' ]
                    ],
                    [
                        'label' => 'Deadline',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'deadline',
                        'value' => 'deadline',
                        'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;' ],
                    ],
                    [
                        'label' => 'Status',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'projectStatus0.statusName',
                        'value' => 'projectStatus0.statusName',
                        'contentOptions' => function ($data){
                                        if($data->projectStatus == 2){
                                        return ['style' => 'color: #808080; font-weight: bold; text-align: center; line-height: 2.5em;' ];
                                        } else {
                                        return ['style' => 'color: #87cd00; font-weight: bold;text-align: center; line-height: 2.5em;' ];
                                        }
                        }
                    ],
                    [
                        'attribute' => 'client.name',
                        'label' => 'Client',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;' ],
                        'format' => 'raw',
                        'value' => function ($data)
                {
                    return Html::button( '<a href="">' . $data->getClientName( $data->clientId ) . '</a>', ['value' => Url::toRoute( ['client/detail', 'id' => $data->clientId ] ), 'class' => 'client-button', 'id' => 'clientButton' ] );
                },
                    ],
                    [
                        'label' => 'Created By',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'creUser.username',
                        'value' => 'creUser.username',
                        'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;' ],
                    ],
                    [
                        'label' => 'Created At',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'creTime',
                        'value' => 'creTime',
                        'contentOptions' => ['style' => 'text-align: center; line-height: 1.5em;' ],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column)
                        {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column)
                        {

                        },
          'expandIcon'=>'<span class="fa fa-angle-right"></span>',
          'collapseIcon'=>'<span class="fa fa-angle-down"></span>',
                                'headerOptions' => ['class' => 'kartik-sheet-style' ],
                                'expandOneOnly' => true,
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 80px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; line-height: 3em;' ],
                                'template' => '{treatment} {parts} {view}',
                                'buttons' => [
                                    'treatment' => function ($url, $model)
                                    {
                                        $filesSearch = ProjectFileData::find()->where(['projectId' => $model->sygnature])->one();
                                        if(isset($filesSearch->projectId)){
                                            
                                        return Html::a( '<span class="fa fa-cogs"></span>', $url, [
                                                        'data-method' => 'post',
                                                        'title' => 'Treatment Files',
                                                        'data' => [                                                         
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        
                                        
                                        } else {
                                            
                                            return '<i class="fa fa-cogs"></i>';
                                        }
                                    },
                                    'parts' => function ($url, $model)
                                    {
                                        $filesSearch = ProjectFileData::find()->where(['projectId' => $model->sygnature])->one();
                                        if(isset($filesSearch->projectId)){
                                            
                                        return Html::a( '<span class="fa fa-th-list"></span>', $url, [
                                                        'data-method' => 'post',
                                                        'title' => 'Technical Documentation',
                                                        'data' => [                                                         
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        
                                        
                                        } else {
                                            
                                            return '<i class="fa fa-th-list"></i>';
                                        }
                                    },
                                            'view' => function($url, $model)
                                    {
                                        return Html::button( '<a href="#"><i class="glyphicon glyphicon-eye-open"></i></a>', ['value' => $url, 'class' => 'view-button', 'id' => 'view-button', 'title' => 'view' ] );

                                    }
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index)
                                {
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['project/cview', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'parts' )
                                    {
                                        $url = Url::toRoute( ['project/cparts', 'sygnature' => $model->sygnature, 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'treatment' )
                                    {
                                        $url = Url::toRoute( ['project/ctreatment', 'sygnature' => $model->sygnature, 'id' => $model->id ] );
                                        return $url;
                                    }
                                }
                                    ],
                                ],
                            ] );
                            ?>

                            <?php Pjax::end(); ?>


                        <?php
                        Modal::begin( [
                            'id' => 'modal',
                            // 'size' => 'SIZE_SMALL',
                            'header' => '<h4 class="modal-title">New Note</h4>',
                                //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
                        ] );
                        echo "<div id='modalContent'></div>";

                        Modal::end();
                        ?>

                            <?php
                            Modal::begin( [
                                'id' => 'client-modal',
                                'size' => 'modal-lg',
                                'header' => '<h4 class="modal-title">Client Detail View</h4>',
                                    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
                            ] );
                            echo "<div id='modalContent'></div>";

                            Modal::end();
                            ?>
    
                        <?php
                            Modal::begin( [
                                'id' => 'view-modal',
                                // 'size' => 'SIZE_SMALL',
                            'header' => '<h4 class="modal-title">Project Details</h4>',
                                //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
                        ] );
                        echo "<div id='modalContent'></div>";

                            Modal::end();
                            ?>


</div>
