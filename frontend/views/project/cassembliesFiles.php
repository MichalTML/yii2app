<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use frontend\models\ProjectAssembliesData;
use frontend\models\FileStatus;
use frontend\models\ProjectAssembliesFilesTypes;
use frontend\models\FilePriority;
use frontend\models\search\ProjectAssembliesFilesNotesSearch;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'P' . $id .  ' Treatment Files Manager';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Project list', 'url' => ['fileindex' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
?>

<div class="project-data-index">


    <?php Pjax::begin(['id' => 'pjax-data']); ?>
    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => false,
        
            'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                    'type'=>'button', 
                    'title'=> ' sdsds', 
                    'class'=>'btn btn-success'
                ]),
            'options' => ['class' => 'btn-group-sm']
        ],
    ],
        'panel' => [
            'type'=>'default',
        ],
        'rowOptions' => function ($model) {
        if($model->statusId == 1){
            return ['style' => 'background-color: #CCF3FF; font-size:12px'];
        }elseif ( $model->statusId == 2)
            {
                return ['style' => 'background-color: #E6FFB2; font-size:12px'];
            }elseif($model->statusId == 3){
                return ['style' => 'background-color: #E599A3; font-size:12px'];
            
        } else {
            return ['style' => 'font-size:12px'];
        }},
        'headerRowOptions' => ['style' => 'font-size:12px'],
        'filterRowOptions' => ['style' => 'max-height: 10px'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'background-color:white;text-align: center; font-weight: bold; line-height: 1em;'],
            ],
//            [
//               'label' => 'Sygnature',
//               'attribute' => 'sygnature',
//               'value' => 'sygnature',
//               'headerOptions' => ['style' => 'text-align: center;' ],
//               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
//           ],
           [
               'label' => 'File Name',
               'attribute' => 'name',
               'value' => 'name',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
            [
               'label' => 'Assemblie',
               'attribute' => 'assemblie.name',
               'filter' => Html::activeDropDownList($searchModel, 'assemblie.name', ArrayHelper::map(ProjectAssembliesData::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'assemblie.name',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
//           [
//               'label' => 'File Size',
//               'attribute' => 'size',
//               'value' => 'size',
//               'headerOptions' => ['style' => 'text-align: center;' ],
//               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
//           ],
           [
               'label' => 'Status',
               'attribute' => 'status.statusName',
               'filter' => Html::activeDropDownList($searchModel, 'status.statusName', ArrayHelper::map(FileStatus::find()->asArray()->all(), 'statusName','statusName'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'status.statusName',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
            [
               'label' => 'Type',
               'attribute' => 'type.name',
               'filter' => Html::activeDropDownList($searchModel, 'type.name', ArrayHelper::map(  ProjectAssembliesFilesTypes::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'type.name',
               'headerOptions' => ['style' => 'text-align: center; width: 170px' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
            [
               'label' => 'Priority',
               'attribute' => 'priority.name',
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', ArrayHelper::map( FilePriority::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'priority.name',
               'headerOptions' => ['style' => 'text-align: center; width: 70px' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
           [
               'label' => 'Ext.',
               'attribute' => 'ext',
               'value' => 'ext',
               'headerOptions' => ['style' => 'text-align: center;width: 70px' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
            [
               'label' => 'Quanity',
               'attribute' => 'quanity',
               'value' => 'quanity',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
           [
               'label' => 'Finished',
               'attribute' => 'quanityDone',
               'value' => 'quanityDone',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
//            [
//                'class' => '\kartik\grid\CheckboxColumn', 
//                'rowHighlight' => false,
//                'hidden' => false,
//                        'contentOptions' => function($model){
//                            if ($model->statusId == 0) {
//                                        return true;
//                                    } elseif ($model->statusId == 3){
//                                        return true;
//                                    }else{
//                                        return false;
//                                    }
//                }
//                ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'background-color:white; min-width: 110px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'background-color:white;text-align:center; line-height: 1em;' ],
                                'template' => '{sendtreatment} {seenote} {note} {download} {view}',
                                'buttons' => [  
                                    'sendtreatment' => function ($url, $model)
                                    {
 
                                   if ($model->statusId == 0) {
                                        return Html::button( '<a href=""><i class="fa fa-paper-plane"></i></a>', ['value' => $url, 'class' => 'send-button', 'id' => 'send', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'treatment send' ] );
                                    } elseif ($model->statusId == 3){
                                        return Html::button( '<a href=""><i class="fa fa-paper-plane"></i></a>', ['value' => $url, 'class' => 'send-button', 'id' => 'send', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'treatment send' ] );
                                    }else{
                                        return '<i class="fa fa-paper-plane-o"></i>';
                                    }
                                    },
                                    'seenote' => function ($url, $model)
                                    {
                                    $searchModel = new ProjectAssembliesFilesNotesSearch();
                                    $searchModel->fileId = $model->id;
                                    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
                                    if ($dataProvider->totalCount > 0) {
                                        return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', ['value' => $url, 'class' => 'seenote-button', 'id' => 'seenote-button', 'title' => 'see notes' , 'data' => $model->id] );
                                    } else {
                                        return '<i class="fa fa-file-o"></i>';

                                    }
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', ['value' => $url, 'class' => 'cnote-button', 'title' => 'new note' ] );
                                    },
                                            'download' => function($url, $model)
                                    {
                                        return Html::a( '<span class="fa fa-download"></span>', $url, [
                                                    'data-method' => 'post',
                                                    'title' => Yii::t( 'app', 'download' ),
                                                ] );
                                    },
                                    
                                            'view' => function($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="glyphicon glyphicon-eye-open"></i></a>', ['value' => $url, 'class' => 'file-button', 'id' => 'file-button', 'title' => 'file details' ] );
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) use ($id) 
                                {
//                                    if ( $action === 'delete' )
//                                    {
//                                        $url = Url::toRoute( ['project-main-files/delete', 'id' => $model->id ] );
//                                        return $url;
//                                    }
                                    if ( $action === 'download' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $model->path, 'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'note' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files-notes/note', 'id' => $model->id ] );
                                        return $url;
                                    }
                                     if ( $action === 'seenote' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files-notes/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'sendtreatment' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/sendtreatment'] );
                                        return $url;
                                    }
                                } 
                                
                                    ],
            ],
                                            
        ]);

        
        
                        Modal::begin( [
                            'id' => 'cmodal',
                            'header' => '<h4 class="modal-title">New Note</h4>',
                        ] );
                        echo "<div id='modalContent'></div>";

                        Modal::end();

                        Modal::begin( [
                            'id' => 'file-notes-modal',
                            'size' => 'lg',
                            'header' => '<h4 class="modal-title">File Notes</h4>',
                        ] );
                        echo "<div id='modalContent'></div>";

                        Modal::end();
                        
                        Modal::begin( [
                                'id' => 'file-modal',
                                'closeButton' => false,
                                'headerOptions' => ['style' => 'display:none' ],
                            'header' => '<h4 class="modal-title">Project Details</h4>',
                                //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
                        ] );
                        echo "<div id='modalContent'></div>";

                            Modal::end();
                            
$this->registerJs("
$(function(){
    // get the click event of the Note button
    $('.cnote-button').click(function(){
        $('#cmodal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});");                          
                            
$this->registerJs("
$(function(){
    // get the click event of the Note button
    $('.seenote-button').click(function(){
        $('#file-notes-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});");   

$this->registerJs(
    "$(document).on('hidden.bs.modal', '#cmodal', function () {
     $.pjax.reload('#pjax-data');
});
    $('.send-button').click(function(){
    var data = $(this).data('id'); 
    var url = $(this).data('url');
     $.ajax({
       url: url,
       type: 'post',
       data: {id: data},
       success: function (msg) {
          $.pjax.reload('#pjax-data');
       }
    
    });
    });
");
$this->registerJs('$(document).on("pjax:timeout", function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});');
        Pjax::end();
?>

</div>