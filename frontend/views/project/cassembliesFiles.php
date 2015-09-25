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
use frontend\models\ProjectAssembliesFiles;
use frontend\models\FileDestination;



$this->title = 'P' . $id .  ' Treatment Files Manager';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Project list', 'url' => ['fileindex' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
?>

<div class="project-data-index">

    <?php Pjax::begin(['id' => 'pjax-data']); ?>
    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['id' => 'grid'],
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => false,
        'toolbar' => [
        [            
            
            'content'=>
            Html::button('<i class="fa fa-home"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'desttma',
                    'type'=>'button', 
                    'title'=> 'destination TMA', 
                    'class'=>'btn btn-success mass-action'
                ]).' '.
            Html::button('<i class="fa fa-sign-out"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'destout',
                    'type'=>'button', 
                    'title'=> 'destination outsource', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => '']
            ],
                [
            'content'=>
            Html::button('LOW', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'lowprio',
                    'type'=>'button', 
                    'title'=> 'set priority low', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
            Html::button('NORMAL', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'normprio',
                    'type'=>'button', 
                    'title'=> 'set priority normal', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
            Html::button('HIGH', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'highprio',
                    'type'=>'button', 
                    'title'=> 'set priority high', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => '']
            ],
                 [
            'content'=>
                Html::button('<i class="fa fa-paper-plane"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'treatfile',
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => 'margin-right:50px;'],                     
        ],
            [
                'content'=>
                Html::button('10', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'10',
                    'type'=>'button', 
                    'title'=> 'send to treat', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('20', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'20',
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('30', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'30',
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]),
            'options' => ['class' => 'btn-group-sm']
            ],
            
    ],
        'panel' => [
            'type'=>'default',
        ],
        'rowOptions' => function ($model) {
        if($model->statusId == 1){
            return ['style' => 'background-color: #CCF3FF; font-size:10px'];
        }elseif ( $model->statusId == 2)
            {
                return ['style' => 'background-color: #E6FFB2; font-size:10px'];
            }elseif($model->statusId == 3){
                return ['style' => 'background-color: #E599A3; font-size:10px'];
            
        } else {
            return ['style' => 'font-size:10px'];
        }},
        'headerRowOptions' => ['style' => 'font-size:10px'],
        'filterRowOptions' => ['style' => 'max-height: 10px'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'background-color:white;text-align: center; font-weight: bold; vertical-align: middle;'],
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
               'headerOptions' => ['style' => 'text-align: center; min-width: 240px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Assemblie',
               'attribute' => 'assemblie.name',
               'filter' => Html::activeDropDownList($searchModel, 'assemblie.name', ArrayHelper::map(ProjectAssembliesData::find()->where( ['projectId' => $sygnature])->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'assemblie.name',
               'headerOptions' => ['style' => 'text-align: center; min-width: 160px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Type',
               'attribute' => 'type.name',
               'filter' => Html::activeDropDownList($searchModel, 'type.name', ArrayHelper::map(  ProjectAssembliesFilesTypes::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'type.name',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
             [
               'label' => 'Material',
               'attribute' => 'material',
               'filter' => Html::activeDropDownList($searchModel, 'material', ArrayHelper::map(  ProjectAssembliesFiles::find()->where(['projectId' => $sygnature])->asArray()->all(), 'material','material'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'material',
               'headerOptions' => ['style' => 'text-align: center; width: 140px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Thick(mm)',
               'attribute' => 'thickness',
               'filter' => Html::activeDropDownList($searchModel, 'thickness', ArrayHelper::map(  ProjectAssembliesFiles::find()->where(['projectId' => $sygnature])->orderBy(['thickness' => SORT_ASC])->asArray()->all(), 'thickness','thickness'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'thickness',
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Status',
               'attribute' => 'status.statusName',
               'filter' => Html::activeDropDownList($searchModel, 'status.statusName', ArrayHelper::map(FileStatus::find()->asArray()->all(), 'statusName','statusName'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'status.statusName',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Dest.',
               'attribute' => 'destination.destination',
               'filter' => Html::activeDropDownList($searchModel, 'destination.destination', ArrayHelper::map(FileDestination::find()->asArray()->all(), 'destination','destination'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'destination.destination',
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => function($model){
            if($model->destinationId == 0){
                return ['style' => 'color: red;text-align: center; vertical-align: middle;' ];
            } else {
            return ['style' => 'color:#87cd00; text-align: center; vertical-align: middle;' ];
               }
               }
           ],
            [
               'label' => 'Priority',
               'attribute' => 'priority.name',
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', ArrayHelper::map( FilePriority::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'priority.name',
               'headerOptions' => ['style' => 'text-align: center; width: 70px' ],
               'contentOptions' => function($model){
               if($model->priorityId == 1){
                   return ['style' => 'color: blue;text-align: center; vertical-align: middle;' ];
               } elseif ($model->priorityId == 0){
                   return ['style' => 'color: orange;text-align: center; vertical-align: middle;' ];
               } else {
                   return ['style' => 'color: red;text-align: center; vertical-align: middle;' ];
               }
               
               }
   
           ],
           [
               'label' => 'Ext.',
               'attribute' => 'ext',
               'value' => 'ext',
               'headerOptions' => ['style' => 'text-align: center;min-width: 55px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Qua.',
               'attribute' => 'quanity',
               'value' => 'quanity',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
           [
               'label' => 'Fin.',
               'attribute' => 'quanityDone',
               'value' => 'quanityDone',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            ['class' => '\kartik\grid\CheckboxColumn',
                   'rowSelectedClass' => 'row-selected',
                ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'background-color:white; min-width: 70px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'margin-top: 5px; background-color:white;text-align:center;  line-height: 2.0;;' ],
                                'template' => '{desttma} {destout} | {priorup} {priordown} {seenote} {note} | {sendtreatment} {download}',
                                'buttons' => [  
                                    'destout' => function ($url, $model)
                                    {
                                    if($model->destinationId == 2){
                                        return '<i class="fa fa-sign-out"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-sign-out"></i></a>', ['value' => $url, 'class' => 'destout-button', 'id' => 'priorup', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'destination outsource' ] );
                                    }},
                                    'desttma' => function ($url, $model)
                                    {
                                    if($model->destinationId == 1){
                                        return '<i class="fa fa-home"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-home"></i></a>', ['value' => $url, 'class' => 'desttma-button', 'id' => 'priorup', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'destination TMA' ] );
                                    }},
                                    'priorup' => function ($url, $model)
                                    {
                                    if($model->priorityId == 2){
                                        return '<i class="fa fa-arrow-up"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-arrow-up"></i></a>', ['value' => $url, 'class' => 'priorup-button', 'id' => 'priorup', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'increase priority' ] );
                                    }},
                                            'priordown' => function ($url, $model){
                                    if($model->priorityId == 0){
                                        return '<i class="fa fa-arrow-down"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-arrow-down"></i></a>', ['value' => $url, 'class' => 'priordown-button', 'id' => 'priordown', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'drecrease priority' ] );
                                            }},
                                    'sendtreatment' => function ($url, $model)
                                    {
 
                                   if ($model->statusId == 0 & $model->destinationId != 0) {
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
                                    
//                                            'view' => function($url, $model)
//                                    {
//                                        return Html::button( '<a href=""><i class="glyphicon glyphicon-eye-open"></i></a>', ['value' => $url, 'class' => 'file-button', 'id' => 'file-button', 'title' => 'file details' ] );
//                                    },
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
//                                    if ( $action === 'view' )
//                                    {
//                                        $url = Url::toRoute( ['project-assemblies-files/view', 'id' => $model->id ] );
//                                        return $url;
//                                    }
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
                                    if ( $action === 'priorup' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/priorup'] );
                                        return $url;
                                    }
                                    if ( $action === 'priordown' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/priordown'] );
                                        return $url;
                                    }
                                    if ( $action === 'desttma' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/desttma'] );
                                        return $url;
                                    }
                                    if ( $action === 'destout' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/destout'] );
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
    $('.priorup-button').click(function(){
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
    $('.priordown-button').click(function(){
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
    $('.desttma-button').click(function(){
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
    $('.destout-button').click(function(){
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
    
    $('.mass-action').click(function(){
       var keys = $('#grid').yiiGridView('getSelectedRows');
       var data = $(this).data('id'); 
       var action = $(this).data('action');
       var url = $(this).data('url');
       if(keys.length > 0){
       $.ajax({
       url: url,
       type: 'post',
       data: {id: keys, action: action},
       success: function (msg) {
          $.pjax.reload('#pjax-data');
       }
    });}
    });
    
    $('.paginations).click(function(){ 
       var pagination = $(this).data('pagination');
       var url = $(this).data('url');
       if(keys.length > 0){
       $.ajax({
       url: url,
       type: 'post',
       data: {pagination: pagination},
       success: function (msg) {
          $.pjax.reload('#pjax-data');
       }
    });}
    });
    
    
");
$this->registerJs('$(document).on("pjax:timeout", function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});');



        Pjax::end();
?>

</div>