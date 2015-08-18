<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\models\search\ProjectSearch;

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

    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'rowOptions' => function($model)
        {
            return ['class' => 'tablew' ];
        },
                'columns' => [
                    'sygnature',
                    [
                        'attribute' => 'projectName',
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'white-space: nowrap;' ]
                    ],
                  
                    'deadline',
                    'projectStatus0.statusName',
                    'client.name',
                    'creUser.username',
                    'creTime',
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
                    
                    return Yii::$app->controller->renderPartial( '_detailView', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'model' => $model,
                    ] );
                },
                        'headerOptions' => ['class' => 'kartik-sheet-style' ],
                        'expandOneOnly' => true,
            ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '',
                        'headerOptions' => ['style' => 'min-width: 70px;text-align: center; border-bottom-color: transparent;' ],
                        'contentOptions' => ['style' => 'text-align:center; line-height: 3em;'],
                        'template' => '{view} {edit} {delete}',
                        'buttons' => [
                            'delete' => function($url, $model)
                            {
                                if ( $model->projectStatus == 2 )
                                {
                                    return '<span class="glyphicon glyphicon-trash"></span>';
                                } else
                                {
                                    return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [ 'data-method' => 'post',
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
                        }
                            ],
                        ],
                    ] );
                    ?>
</div>
