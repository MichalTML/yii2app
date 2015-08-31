<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\models\search\ProjectSearch;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use frontend\models\ProjectNotes;

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
                    [
             'attribute' => 'client.name',
             'label'=>'Client',
             'format' => 'raw',
             'value'=> function ($data){
            return Html::button( '<a href="">'.$data->getClientName($data->clientId).'</a>', 
            ['value' => Url::toRoute( ['client/detail', 'id' => $data->clientId ] ), 'class' => 'client-button', 'id' => 'clientButton'] );
                      },
             ],
                    

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
                            $projectNotes = new ProjectNotes;
                            
                            return Yii::$app->controller->renderPartial( '_detailView', [
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'model' => $model,
                                        'notes' => $projectNotes,
                                    ] );
                        },
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
                                        return Html::button( '<a href=""><i class="fa fa-th-list"></i></a>', ['value' => $url, 'class' => 'parts-button', 'id' => 'partsButton'] );
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', ['value' => $url, 'class' => 'note-button', 'id' => 'modalButton'] );
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
                                        $url = Url::toRoute( ['project/parts', 'sygnature' => $model->sygnature ] );
                                        return $url;
                                    }
                                }
                                    ],
                                ],
                            ] );
                            ?>

                            <?php Pjax::end(); ?>


<?php Modal::begin([
    'id' => 'modal',
   // 'size' => 'SIZE_SMALL',
    'header' => '<h4 class="modal-title">New Note</h4>',
    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
    echo "<div id='modalContent'></div>";
    
Modal::end(); ?>
    
    <?php Modal::begin([
    'id' => 'parts-modal',
    'size' => 'modal-lg',
    'header' => '<h4 class="modal-title"></h4>',
    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
    echo "<div id='modalContent'></div>";
    
Modal::end(); ?>
    
    <?php Modal::begin([
    'id' => 'client-modal',
    'size' => 'modal-lg',
    'header' => '<h4 class="modal-title">Client Detail View</h4>',
    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
    echo "<div id='modalContent'></div>";
    
Modal::end(); ?>
    
    
</div>
