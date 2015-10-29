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
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\FilesImages;

$this->title = 'P' . $sygnature .  ' Treatment Files Manager';
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
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => '']
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
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => '']
            ],
                 [
            'content'=>
                Html::button('<i class="fa fa-paper-plane"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '1'] ),
                    'data-action'=>'sendtotreatment',
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => 'margin-right:50px;'],                     
        ],
            [
                'content'=>
                Html::button('10', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'10',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treat', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('20', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'20',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('30', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination'] ),
                    'data-pagination'=>'30',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'send to treatment', 
                    'class'=>'btn btn-success paginations'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group']
            ],
            
    ],
        'panel' => [
            'headingOptions' => ['style' => 'color: #808080;'],
            'contentOptions' => ['style' => 'width: 100%'],
            'type'=>'default',
        ],
         'rowOptions' => function ($model) {
            $notesCheck = ProjectAssembliesFilesNotes::find()
                                ->Where(['fileId' => $model->id] )
                                ->all();
            if($notesCheck){
                return ['class' => 'treatment-note lighted-row', 'style' => 'font-size:10px'];
            }
            return ['class' => 'lighted-row', 'style' => 'font-size:10px'];
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
               'filter' => Html::activeDropDownList($searchModel, 'assemblie.name', 
                           ArrayHelper::map(ProjectAssembliesData::find()
                           ->where( ['projectId' => $sygnature])->asArray()->all(), 'name','name'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'assemblie.name',
               'headerOptions' => ['style' => 'text-align: center; min-width: 160px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Type',
               'attribute' => 'type.name',
               'filter' => Html::activeDropDownList($searchModel, 'type.name', 
                           ArrayHelper::map(  ProjectAssembliesFilesTypes::find()
                           ->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'type.name',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
             [
               'label' => 'Material',
               'attribute' => 'material',
               'filter' => Html::activeDropDownList($searchModel, 'material', 
                           ArrayHelper::map(  ProjectAssembliesFiles::find()
                           ->where(['projectId' => $sygnature])->asArray()->all(), 'material','material'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'material',
               'headerOptions' => ['style' => 'text-align: center; width: 140px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Thick(mm)',
               'attribute' => 'thickness',
               'filter' => Html::activeDropDownList($searchModel, 'thickness', 
                           ArrayHelper::map(  ProjectAssembliesFiles::find()
                           ->where(['projectId' => $sygnature])
                           ->orderBy(['thickness' => SORT_ASC])->asArray()->all(), 'thickness','thickness'),
                          ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'thickness',
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Status',
               'attribute' => 'status.statusName',
               'filter' => Html::activeDropDownList($searchModel, 'status.statusName',
                           ArrayHelper::map(FileStatus::find()->asArray()->all(), 'statusName','statusName'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'status.statusName',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px;' ],
               'contentOptions' => function ($model) {
                                if($model->statusId == 1){
                                    return ['style' => 'vertical-align: middle; text-align: center; background-color: #CCF3FF;'];
                                }elseif ( $model->statusId == 2){
                                    return ['style' => 'vertical-align: middle; text-align: center; background-color: #E6FFB2;'];
                                }elseif($model->statusId == 3){
                                    return ['style' => 'vertical-align: middle; text-align: center; background-color: #E599A3;'];
                                }elseif($model->statusId == 4){
                                    return ['style' => 'vertical-align: middle; text-align: center; background-color: #aac0ee;'];  
                                }},
            ],
            [
               'label' => 'Dest.',
               'attribute' => 'destination.destination',
               'filter' => Html::activeDropDownList($searchModel, 'destination.destination', 
                           ArrayHelper::map(FileDestination::find()->asArray()->all(), 'destination','destination'),
                           ['class'=>'form-control', 'prompt' => ' ']),
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
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', 
                           ArrayHelper::map( FilePriority::find()->asArray()->all(), 'name','name'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'priority.name',
               'headerOptions' => ['style' => 'text-align: center; width: 70px' ],
               'contentOptions' => function($model){
               if($model->priorityId == 1){
                   return ['style' => 'background-color: #b9c9fe; color: white;text-align: center; vertical-align: middle;' ];
               } elseif ($model->priorityId == 0){
                   return ['style' => 'background-color: #fdbe87;color: white;text-align: center; vertical-align: middle;' ];
               } else {
                   return ['style' => 'background-color: #fb2d2d;color: white;text-align: center; vertical-align: middle;' ];
               }
               
               }
           ],
            [
               'label' => 'Qua.',
               'attribute' => 'quanity',
               'value' => 'quanity',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => function($model){
                if($model->quanity == $model->quanityDone){
                        return['style' => 'background-color:#E6FFB2 ;text-align: center; vertical-align: middle;' ];
                    } else {
                        return['style' => 'background-color:white; text-align: center; vertical-align: middle;' ];
                    }
               },
                
           ],
           [
               'label' => 'Fin.',
               'attribute' => 'quanityDone',
               'value' => 'quanityDone',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => function($model){
                if($model->quanity == $model->quanityDone){
                        return['style' => 'background-color:#E6FFB2 ;text-align: center; vertical-align: middle;' ];
                    } else {
                        return['style' => 'background-color:white; text-align: center; vertical-align: middle;' ];
                    }
               },
            ],
            ['class' => '\kartik\grid\CheckboxColumn',
                   'rowSelectedClass' => 'row-selected',
                    'contentOptions' => ['style' => 'background-color: white;'],
                ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'background-color:white; min-width: 70px; text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => function(){                                
                                    return ['style' => 'margin-top: 5px; background-color:text-align:center; vartical-align:middle;' ];
                                },
                                'template' => '{desttma} {destout} | {priorup} {priordown} {seenote} {note} | {downloaddxf} {downloadpdf}',
                                'buttons' => [  
                                    'destout' => function ($url, $model)
                                    {
                                    if($model->destinationId == 2){
                                        return '<i class="fa fa-sign-out"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-sign-out"></i></a>', 
                                               ['value' => $url, 'class' => 'destout-button', 'id' => 'priorup', 
                                               'data-id' => $model->id, 'data-url' => $url, 'title' => 'destination outsource' ] );
                                    }},
                                    'desttma' => function ($url, $model)
                                    {
                                    if($model->destinationId == 1){
                                        return '<i class="fa fa-home"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-home"></i></a>', 
                                               ['value' => $url, 'class' => 'desttma-button', 'id' => 'priorup', 
                                               'data-id' => $model->id, 'data-url' => $url, 'title' => 'destination TMA' ] );
                                    }},
                                    'priorup' => function ($url, $model)
                                    {
                                    if($model->priorityId == 2){
                                        return '<i class="fa fa-arrow-up"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-arrow-up"></i></a>', 
                                               ['value' => $url, 'class' => 'priorup-button', 'id' => 'priorup', 
                                               'data-id' => $model->id, 'data-url' => $url, 'title' => 'increase priority' ] );
                                    }},
                                            'priordown' => function ($url, $model){
                                    if($model->priorityId == 0){
                                        return '<i class="fa fa-arrow-down"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-arrow-down"></i></a>', 
                                               ['value' => $url, 'class' => 'priordown-button', 'id' => 'priordown', 
                                               'data-id' => $model->id, 'data-url' => $url, 'title' => 'drecrease priority' ] );
                                            }},
                                    'seenote' => function ($url, $model)
                                    {
                                                
                                    $searchModel = new ProjectAssembliesFilesNotesSearch();
                                    $searchModel->fileId = $model->id;
                                    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

                                        if ($dataProvider->totalCount > 0) {
                                            return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', 
                                                   ['file-name' => $model->name, 'value' => $url, 'class' => 'seenote-button', 
                                                   'id' => 'seenote-button', 'title' => 'see notes' , 'data' => $model->id] );
                                        } else {
                                            return '<i class="fa fa-file-o"></i>';
                                        }
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', 
                                               ['value' => $url, 'class' => 'cnote-button', 'title' => 'new note' ] );
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
                                            $fileId = ProjectAssembliesFiles::find()
                                            ->select(['id'])->where(['name' => $model->name, 'ext' => 'pdf'])->one();
                                            
                                            $fileImage = FilesImages::find()->select(['imagePath'])
                                            ->where(['fileId' => $fileId->id])->one();
                                            
                                                if($fileImage){
                                                    return Html::a( '<span class="fa fa-file-pdf-o"></span>', $url, [
                                                      'data-method' => 'post',
                                                      'title' => Yii::t( 'app', 'download PDF' ),
                                                      'class' => $model->id,
                                                      'image-path' => $fileImage->imagePath,
                                                    ] );  
                                                }
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
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $path, 
                                               'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                        } else {
                                            $url = '';
                                        }
                                    }
                                    if ( $action === 'downloaddxf' )
                                    {
                                        $path = ProjectAssembliesFiles::getFile($model->sygnature, $model->name, 'dxf');
                                        if($path){
                                        $url = Url::toRoute( ['project-assemblies-files/download', 'path' => $path, 
                                               'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                        } else {
                                            $url = '';
                                        }
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

        
        
                        
                            
$this->registerJs("
    /////////////// MODAL SETTINGS

    // Prevent default timeout redirection behavior
    $('#pjax-data').on('pjax:timeout', function(event) {
        event.preventDefault()
    });

    // Refresh pjax after modal event
    $('#modal-window').on('hidden.bs.modal', function () {
        var classCheck =  $('.modal-content').attr('class');
            if(classCheck === 'modal-content pdf-view'){
                $('.modal-content').css('background-image', '');
                $('.modal-content').removeClass('pdf-view');               
             } else {
                 $('.modal-header').css('border-bottom', '1px solid #e5e5e5');
                 $.pjax.reload('#pjax-data');
             }   
    });  
    
    ///////////////// MODAL EVENTS
    
    // CREATE NOTE EVENT
    $(function(){
    // get the click event of the Note button
    $('.cnote-button').click(function(){
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    
    // View Note ACtion / change Note Title    
    $('.seenote-button').click(function(){
    
        var fileName = $(this).attr('file-name');
        $('.modal-title').empty();
        $('.modal-title').append('<span class=\\'title\\'>Element: ' + fileName + '</span>');
        $('.modal-header').addClass('color-title');
        
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    
    //////////////// OTHER EVENTS
    
    // Add light effect AND PDF view
    $('.lighted-row').each(function(){  
        $(':lt(12)', this).css('cursor', 'pointer');
        var rowId;
        var imagePath;
        $(this).hover(  
          function() {
                rowId = $(this).attr('data-key');                
                $(this).addClass('light-on-treatment');
          }, function() {
                $(this).removeClass('light-on-treatment');
          }
        );

        $(':lt(12)', this).click(function(){
            
            imagePath = $('.' + rowId).attr('image-path');
            if(typeof imagePath != 'undefined'){
                $('#modal-window').modal('show');
                $('.modal-content').css('background-image', 'url(' + imagePath + ')');
                $('.modal-content').addClass('pdf-view');
                $('.modal-header').css('border-bottom', '0');
           }
        }); 
    }); 
    
    // SEND FILE
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
    
    // PRIOR UP
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
    
    // PRIOR DOWN
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
    
    // DEST TMA
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
    
    // DEST OUT
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
    
    // MASS ACTION & KEEP SELECTED
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
                    });
                }

        $(document).one('ajaxStop', function() {
                if(keys.length > 0){
                    for( var x = 0; x < keys.length; x++){
                        $('input[value=' + keys[x] + ']').prop('checked', false);
                        $('input[value=' + keys[x] + ']').prop('checked', true);    
                    }
                }
        });      
    });
    
    //PAGINATION
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
});");                          

    Pjax::end();

    Modal::begin( [
            'id' => 'modal-window',
            'header' => '<h4 class="modal-title">New Note</h4>',
    ] );
        
    echo "<div id='modalContent'></div>";

   Modal::end();

?>

</div>