<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\User;
use frontend\models\Status;
use frontend\models\search\UserSearch;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Administration';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="user-index">

    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//    'rowOptions' => function ($model){
//                if($model->status_id == 0) {
//                    return ['class' => 'danger'];
//                } else {
//                    return ['class' => 'success'];
//                }
//    },
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            [
                'label' => 'User Name',
                'attribute' => 'username',
                'value' => 'username',
                'width' => '100px',
                'hAlign' => 'left'
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'format' => 'email',
                'value' => 'email',
                'width' => '120px',
                'hAlign' => 'left'
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status_id',
                'filter' => Html::activeDropDownList( $searchModel, 'status.status_name', ArrayHelper::map( Status::find()->asArray()->all(), 'status_name', 'status_name' ), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'format' => 'raw',
                'value' => 'status.status_name',
                'editableOptions' => [
                    'header' => '.',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => User::getStatusList(),
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-success' ],
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'role_id',
                'filter' => Html::activeDropDownList( $searchModel, 'role.role_name', User::getSearchRoleList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'value' => 'role.role_name',
                'editableOptions' => [
                    'header' => '.',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => User::getEditableRoleList(),
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-info' ]
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
                'pageSummary' => false
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column)
                {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column)
                {
                    $searchModel = new UserSearch();
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
                        'header' => 'Action',
                        'headerOptions' => ['style' => 'width: 70px;text-align: center;'],
                        'contentOptions' => ['style' => 'text-align:center; line-height: 2em;'],
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function($url, $model)
                            {
                                if ( 2 == 12 )
                                {
                                    return '<span class="glyphicon glyphicon-trash"></span>';
                                } else
                                {
                                    return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [ 'data-method' => 'post',
                                                'title' => Yii::t( 'app', 'delete' ),
                                                'data' => [
                                                'confirm' => 'You are about to delete: ' . $model->username . ' ,are you sure you want to proceed?',
                                                    'method' => 'post',
                                                ],
                                            ] );
                                }
                            },
                                    'edit' => function($url, $model)
                            {
                                if ( 2 == 12 )
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
                                $url = Url::toRoute( ['user/delete', 'id' => $model->id ] );
                                return $url;
                            }
                            if ( $action === 'edit' )
                            {
                                $url = Url::toRoute( ['user/update', 'id' => $model->id ] );
                                return $url;
                            }
                            if ( $action === 'view' )
                            {
                                $url = Url::toRoute( ['user/view', 'id' => $model->id ] );
                                return $url;
                            }
                        }
                            ],   
                ]
            ] );
            ?>

</div>
