<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\models\search\ProjectSearch;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use frontend\models\ProjectNotes;
use frontend\models\ProjectFileData;
use frontend\models\ProjectData;

$this->title = 'Projects list';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>

<div class="project-data-index">

    <p>
        <?= Html::a( 'New project', ['create' ], ['class' => 'btn btn-primary' ] ) ?>
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
        'headerRowOptions' => ['style' => 'font-size: 12px'],
        'rowOptions' => function ($model)
                        {
                        $filesSearch = ProjectFileData::find()->where(['projectId' => $model->sygnature])->one();
                            if(isset($filesSearch->projectId)){                                            
                                return ["style" => "background-color:#e6e6e6; font-size:12px"];                                
                            } else {
                                return ["style" => "border-color:white; font-size:12px"];
                                    }},
                'columns' => [
                    [
                        'label' => 'Project Nr',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'sygnature',
                        'value' => 'sygnature',
                        'filter' => Html::activeDropDownList( $searchModel, 'sygnature', 
                        ProjectData::getSygnatures(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                    ],
                    [
                        'label' => 'Project Name',
                        'attribute' => 'projectName',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ]
                    ],                    
                    [
                        'label' => 'Status',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'projectStatus0.statusName',
                        'value' => 'projectStatus0.statusName',
                        'filter' => Html::activeDropDownList( $searchModel, 'projectStatus0.statusName', 
                        ProjectData::getProjectStatusList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                        'contentOptions' => function ($data){
                                        if($data->projectStatus == 2){
                                       return ['style' => 'color: #808080; font-weight: bold; text-align: center; vertical-align: middle;' ];
                                        } elseif($data->projectStatus == 3) {
                                       return ['style' => 'color: #cc8800; font-weight: bold;text-align: center; vertical-align: middle;' ];
                                        } else {
                                       return ['style' => 'color: #87cd00; font-weight: bold;text-align: center; vertical-align: middle;' ];                                          }
                        }
                    ],
                    [
                        'attribute' => 'client.abr',
                        'label' => 'Client',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'contentOptions' => ['style' => ' color: #337ab7; text-align: center; vertical-align: middle;' ],
                        'format' => 'raw',
                        'value' => function ($data)
                {
                    return Html::button( $data->getClientName( $data->clientId ) , 
                 ['value' => Url::toRoute( ['client/detail', 'id' => $data->clientId ] ), 
                 'client-name' => $data->getClientName( $data->clientId ),'class' => 'client-button', 'id' => 'clientButton' ] );
                },
                    ],
                         [
                        'label' => 'projectStart',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'projectStart',
                        'value' => 'projectStart',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                    ],
                    [
                        'label' => 'Deadline',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'deadline',
                        'value' => 'deadline',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                    ],
                    [
                        'label' => 'Updated By',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'updUser.username',
                        'value' => 'updUser.username',                        
                        'filter' => Html::activeDropDownList( $searchModel, 'updUser.username', 
                        ProjectData::getCreUserList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
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
                                'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;' ],
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
                                        return Html::button( '<i style="color: #337ab7;" class="fa fa-file-text-o"></i>',
                                        ['value' => $url, 'class' => 'note-button', 'project-name' => $model->projectName, 'id' => 'modalButton', 'title' => 'new note' ] );
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
                                    'confirm' => 'You are about to delete: ' . $model->projectName . ', are you sure you want to proceed?',
                                                         'method' => 'post',
                                                        ],
                                                    ] );
                                        }
                                    },
                                        'edit' => function($url, $model)
                                    {
                                        if ( $model->projectStatus == 22 )
                                        {
                                            return '<span class="glyphicon glyphicon-pencil"></span>';
                                        } else
                                        {
                                            return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, 
                                            [ 'data-method' => 'post', 'title' => Yii::t( 'app', 'edit' ) ] );
                                        }
                                    },
                                        'view' => function($url, $model)
                                    {
                                        return Html::button( '<a href="#"><i class="glyphicon glyphicon-eye-open"></i></a>', 
                                               ['value' => $url, 'class' => 'view-button', 'project-name' => $model->projectName, 
                                               'id' => 'view-button', 'title' => 'view' ] );

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
                            
    
$this->registerJs("  
$(function(){
    // CREATE NOTE
    $('.note-button').click(function(){
        var projectName = $(this).attr('project-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('Note to: ' + projectName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(function(){
    // get the click event of the Note button
    $('.client-button').click(function(){
        var clientName = $(this).attr('client-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('Client: ' + clientName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(function(){
    // get the click event of the Note button
    $('.view-button').click(function(){
        var projectName = $(this).attr('project-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('Project: ' + projectName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});"
);
?>


</div>
<?php Pjax::end(); 
Modal::begin( [
    'id' => 'modal-window',
    'header' => '<h4 class="modal-title"></h4>',
    ]);
    echo "<div id='modalContent'></div>";
Modal::end();
