<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\ProjectData;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Projects list';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="project-data-index">

    <!--    <h1> Html::encode($this->title) </h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( 'Create new project', ['create' ], ['class' => 'btn btn-default login' ] ) ?>
    </p>

    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model)
        {
            return ['class' => 'tablew' ];
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'color: black;' ],
                    ],
                    'sygnature',
                    //'projectName',
                    [
                        'attribute' => 'projectName',
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'white-space: nowrap;' ]
                    ],
                    [
                        'attribute' => 'Constructors',
                        'value' => 'ProjectPermissionsUsers',
                        'contentOptions' => ['style' => 'word-wrap: break-word;' ]
                    ],
                    'deadline',
                    'projectStatus0.statusName',
                    'client.name',
//          [
//                'attribute' => 'projectPermissions.userId',
//                'value' => function ($data) {
//                 $str = '';
//                 foreach($data->projectPermissions as $permission) {
//                 $str .= $permission->userId.',';
//                 }
//                 return $str;
//                },
//            ],
                    //'projectPermissionsUsers',
                    'creUser.username',
                    'creTime',
                    //'updUserName',
                    //'updTime',
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Action',
                        'headerOptions' => ['style' => 'min-width: 70px;text-align: center;' ],
                        'template' => '{view} {edit} {delete}',
                        'buttons' => [
                            'delete' => function($url, $model)
                            {
                                if ( $model->projectStatus == 2 )
                                {   
                                    return '<span class="glyphicon glyphicon-trash"></span>';
                                } else {
                                    return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [ 'data-method' => 'post',
                                                'title' => Yii::t( 'app', 'delete' ),
                                                'data' => [
                                                    'confirm' => 'You are about to delete: ' . $model->projectName . ' ,are you sure you want to proceed?',
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
                                } else {
                                    return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'data-method' => 'post',
                                        'title' => Yii::t( 'app', 'edit')]);
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
                            if ( $action === 'edit')
                            {
                                $url = Url::toRoute( ['project/update', 'id' => $model->id ] );
                                return $url;
                            }
                                if ( $action === 'view')
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
