<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use frontend\models\ProjectAssembliesData;
use frontend\models\ProjectAssembliesFilesTypes;
use frontend\models\FilePriority;
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\ProjectAssembliesFiles;
use frontend\models\FileDestination;



$this->title = 'P' . $sygnature .  ' Treatment Files Manager';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Project list', 'url' => ['treatmentindex' ] ];
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
            Html::button('<i class="fa fa-plus"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'add',
                    'type'=>'button', 
                    'title'=> '+1 ready file', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
            Html::button('<i class="fa fa-minus"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'deduct',
                    'type'=>'button', 
                    'title'=> '-1 ready file', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => '']
            ],
                 [
            'content'=>
                Html::button('<i class="fa fa-paper-plane"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '2'] ),
                    'data-action'=>'treatfile',
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
                 Html::button('<i class="fa fa-exclamation-triangle"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '3'] ),
                    'data-action'=>'rejectfile',
                    'type'=>'button', 
                    'title'=> 'reject file', 
                    'class'=>'btn btn-success mass-action'
                ]),    
            'options' => ['class' => 'btn-group-sm', 'style' => 'margin-right:50px;'],                     
        ],
            [
                'content'=>
                Html::button('10', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'10',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treat', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('20', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'20',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('30', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'30',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]),
            'options' => ['class' => 'btn-group-sm']
            ],
            
    ],
        'panel' => [
            'headingOptions' => ['style' => 'color: #808080;'],
            'type'=>'default',
        ],
        'rowOptions' => function ($model) {
            $notesCheck = ProjectAssembliesFilesNotes::find()
                                ->andWhere(['fileId' => $model->id] )
                                ->andWhere(['typeId' => 0])
                                ->all();
            if($notesCheck){
                return ['style' => 'background-color: #e6e6e6; font-size:10px'];
            }
            return ['style' => 'font-size:10px'];
        },
        'headerRowOptions' => ['style' => 'font-size:10px'],
        'filterRowOptions' => ['style' => 'max-height: 10px'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => [ 'style' => 'text-align: center; font-weight: bold; vertical-align: middle;', 'class' => 'serial-col'],
            ],
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
               'filter' => Html::activeDropDownList($searchModel, 'thickness', ArrayHelper::map(  ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'statusId' => '1', 'ext' => 'dft'])->orderBy(['thickness' => SORT_ASC])->asArray()->all(), 'thickness','thickness'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'thickness',
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
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
                                'template' => '{seenote} {note} | {downloaddxf} {downloadpdf} <br /> {add} {deduct} | {sendtreatment} {reject}',
                                'buttons' => [  
                                    'add' => function ($url, $model)
                                    {
                                    if($model->quanityDone == $model->quanity){
                                        return '<i class="fa fa-plus"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-plus"></i></a>', ['value' => $url, 'class' => 'add-button', 'id' => 'add', 'data-id' => $model->id, 'data-url' => $url, 'title' => '+1 ready file' ] );
                                    }},
                                    'deduct' => function ($url, $model){
                                    if($model->quanityDone == 0){
                                        return '<i class="fa fa-minus"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-minus"></i></a>', ['value' => $url, 'class' => 'deduct-button', 'id' => 'deduct', 'data-id' => $model->id, 'data-url' => $url, 'title' => '-1 ready file' ] );
                                            }},
                                    'sendtreatment' => function ($url, $model)
                                    {
 
                                   if ($model->quanity == $model->quanityDone & $model->destinationId != 0) {
                                        return Html::button( '<a href=""><i class="fa fa-paper-plane"></i></a>', ['value' => $url, 'class' => 'send-button', 'id' => 'send', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'treatment send' ] );
                                    }else{
                                        return '<i class="fa fa-paper-plane-o"></i>';
                                    }
                                    },
                                            'reject' => function ($url, $model)
                                    {
                                        $notesCheck = ProjectAssembliesFilesNotes::find()
                                        ->andWhere(['fileId' => $model->id] )
                                        ->andWhere(['typeId' => 3])
                                        ->all();
                                   if ($model->statusId == 1 & $model->destinationId != 0 & $notesCheck) {
                                        return Html::button( '<a href=""><i class="fa fa-exclamation-triangle"></i></a>', ['value' => $url, 'class' => 'reject-button', 'id' => 'reject', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'reject file' ] );
                                    }else{
                                        return '<i class="fa fa-exclamation-triangle"></i>';
                                    }
                                    },
                                    'seenote' => function ($url, $model)
                                    {
                                    $searchModel = new ProjectAssembliesFilesNotes;
                                    $result = $searchModel->find()
                                            ->andFilterWhere(['fileId' => $model->id])
                                            ->andFilterWhere(['typeId' => 0])
                                            ->all();
                                    
                                    if ($result) {
                                        return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', ['value' => $url, 'class' => 'seenote-button', 'id' => 'seenote-button', 'title' => 'see notes' , 'data' => $model->id] );
                                    } else {
                                        return '<i class="fa fa-file-o"></i>';

                                    }
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', ['value' => $url, 'class' => 'cnote-button', 'title' => 'new note' ] );
                                    },
                                    'downloaddxf' => function($url, $model)
                                    {
                                        if($url){
                                        return Html::a( '<span class="fa fa-download"></span>', $url, [
                                                    'data-method' => 'post',
                                                    'title' => Yii::t( 'app', 'download DXF' ),
                                                ] );
                                        }
                                        return '<span class="fa fa-download"></span>';
                                    },
                                    'downloadpdf' => function($url, $model)
                                    {
                                        if($url){
                                        return Html::a( '<span class="fa fa-file-pdf-o"></span>', $url, [
                                                    'data-method' => 'post',
                                                    'title' => Yii::t( 'app', 'download PDF' ),
                                                ] );
                                        }
                                        return '<span class="fa fa-file-pdf-o"></span>';
                                    },
                                        ],
                                    'urlCreator' => function ($action, $model, $key, $index) use ($id) 
                                {
                                    if ( $action === 'downloadpdf' )
                                    {
                                        $path = ProjectAssembliesFiles::getFile($model->sygnature, $model->name, 'pdf');
                                        if($path){
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $path, 'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                        } else {
                                            $url = '';
                                        }
                                    }
                                    if ( $action === 'downloaddxf' )
                                    {
                                        $path = ProjectAssembliesFiles::getFile($model->sygnature, $model->name, 'dxf');
                                        if($path){
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $path, 'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                        } else {
                                            $url = '';
                                        }
                                    }
                                    if ( $action === 'note' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files-notes/tnote', 'id' => $model->id ] );
                                        return $url;
                                    }
                                     if ( $action === 'seenote' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files-notes/view', 'id' => $model->id, 'filter' => 0 ] );
                                        return $url;
                                    }
                                    if ( $action === 'reject' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/sendtreatment', 'action' => 3] );
                                        return $url;
                                    }
                                    if ( $action === 'sendtreatment' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/sendtreatment', 'action' => '2'] );
                                        return $url;
                                    }
                                    if ( $action === 'add' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/add'] );
                                        return $url;
                                    }
                                    if ( $action === 'deduct' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files/deduct'] );
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
    
    $('.reject-button').click(function(){
    var result = confirm('Are you sure you want to reject this file?');
    if(result){
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
    }
    });
    
    $('.deduct-button').click(function(){
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
    
    $('.add-button').click(function(){
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
    $(document).ajaxStop(function(){
        for( var x = 0; x < keys.length; x++){
            $('tr[data-key=' + keys[x] + '] > td > input').prop('checked', true);
        }
    });
    });
    
    $('.paginations').click(function(){ 
       var pagination = $(this).data('pagination');
       var id = $(this).data('id');
       var sygnature = $(this).data('sygnature');
       var url = $(this).data('url');
       $.ajax({
       url: url,
       type: 'post',
       data: {pagination: pagination, sygnature: sygnature, id: id},
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