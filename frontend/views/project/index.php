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

    <p>
        <?= Html::a( 'New project', ['create' ], ['class' => 'btn btn-default login' ] ) ?>
    </p>

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
                                            
                                        return ["style" => "background-color:#e6e6e6;"];
                                        
                                        
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
                            $searchModel = new ProjectSearch();
                            $searchModel->id = $model->id;
                            $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
                            $projectNotes = new ProjectNotes;

                            return Yii::$app->controller->renderPartial( '_detailView', [
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'model' => $model,
                                        'notes' => $projectNotes,
                                    ] );
                        },
          'expandIcon'=>'<span class="fa fa-angle-right"></span>',
          'collapseIcon'=>'<span class="fa fa-angle-down"></span>',
                                'headerOptions' => ['class' => 'kartik-sheet-style' ],
                                'expandOneOnly' => true,
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 110px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; line-height: 3em;' ],
                                'template' => '{parts} {note} {view} {edit} {delete}',
                                'buttons' => [
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
                                            'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', ['value' => $url, 'class' => 'note-button', 'id' => 'modalButton', 'title' => 'new note' ] );
                                    },
                                            'delete' => function($url, $model)
                                    {
                                        if ( $model->projectStatus == 2 )
                                        {
                                            return '<span class="glyphicon glyphicon-trash"></span>';
                                        } else
                                        {
                                            return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                        'data-method' => 'post',
                                                        'title' => Yii::t( 'app', 'delete' ),
                                                        'data' => [
                                                            'confirm' => 'You are about to delete: ' . $model->projectName . ' ,are you sure you want to                                                proceed?',
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        }
                                    },
                                            'edit' => function($url, $model)
                                    {
                                        if ( $model->projectStatus == 2 )
                                        {
                                            return '<span class="glyphicon glyphicon-pencil"></span>';
                                        } else
                                        {
                                            return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'data-method' => 'post',
                                                        'title' => Yii::t( 'app', 'edit' ) ] );
                                        }
                                    },
                                            'view' => function($url, $model)
                                    {
                                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                                    'data-method' => 'post',
                                                    'title' => Yii::t( 'app', 'view' ),
                                                ] );
                                    }
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index)
                                {
                                    if ( $action === 'delete' )
                                    {
                                        $url = Url::toRoute( ['project/delete', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'edit' )
                                    {
                                        $url = Url::toRoute( ['project/update', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['project/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'note' )
                                    {
                                        $url = Url::toRoute( ['project-notes/note', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'parts' )
                                    {
                                        $url = Url::toRoute( ['project/parts', 'sygnature' => $model->sygnature, 'id' => $model->id ] );
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


</div>
