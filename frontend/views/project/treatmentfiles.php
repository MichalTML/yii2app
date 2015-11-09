<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use frontend\models\FilePriority;
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\ProjectAssembliesFiles;
use frontend\models\FilesImages;

$this->title = 'P' . $sygnature .  ' Treatment Files Manager';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Project list', 'url' => ['treatmentindex' ] ];
$this->params[ 'breadcrumbs' ][] = 'P' . $sygnature . ' - Pending Files';
$this->params[ 'breadcrumbs' ][] = ['label' => 'P' . $sygnature . ' - Accepted Files', 
    'url' => ['treatmentmanagera', 'sygnature' => $sygnature, 'id' => $id] ];
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
            Html::button('<i class="fa fa-check-circle-o fa-2x"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'accept',
                    'type'=>'button', 
                    'title'=> 'accept file', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => 'margin-right: 50px']
            ],
                 [
            'content'=>
                 Html::button('<i class="fa fa-exclamation-triangle"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '3'] ),
                    'data-action'=>'rejectfile',
                    'type'=>'button', 
                    'title'=> 'reject file', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
                 Html::button('<i class="fa fa-arrow-circle-down"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '2'] ),
                    'data-url2'=> Url::toRoute( ['project-assemblies-files/downloadzip'] ),
                    'data-action'=>'download',
                    'type'=>'button', 
                    'title'=> 'download file package', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => 'margin-right:50px;'],                     
            ],
            [
                'content'=>
                Html::button('10', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'10',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'show 10 records', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('20', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'20',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'show 20 records', 
                    'class'=>'btn btn-success paginations'
                ]).' '.
                Html::button('30', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/pagination', 'target' => 'treatment'] ),
                    'data-pagination'=>'30',
                    'data-id'=> $id,
                    'data-sygnature'=> $sygnature,
                    'type'=>'button', 
                    'title'=> 'show 30 records', 
                    'class'=>'btn btn-success paginations'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group']
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
                return ['class' => 'lighted-row', 'style' => 'background-color: #fef7b9; font-size:10px'];
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
               'contentOptions' => ['style' => 'padding-left: 10px; text-align: left; vertical-align: middle;' ],
           ],
           [
               'label' => 'Material',
               'attribute' => 'material',
               'filter' => Html::activeDropDownList($searchModel, 'material', 
                       ArrayHelper::map(  ProjectAssembliesFiles::find()->where(['projectId' => $sygnature])->asArray()->all(), 
                               'material','material'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'material',
               'headerOptions' => ['style' => 'text-align: center; width: 140px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Thick(mm)',
               'attribute' => 'thickness',
               'filter' => Html::activeDropDownList($searchModel, 'thickness', 
                       ArrayHelper::map(  ProjectAssembliesFiles::find()
                               ->where(['projectId' => $sygnature, 'statusId' => '1', 'ext' => 'dft'])
                               ->orderBy(['thickness' => SORT_ASC])->asArray()->all(), 
                               'thickness','thickness'),['class'=>'form-control', 'prompt' => ' ']),
               'format' => 'raw',
               'value' => function($model){
                                if($model->typeId == 5){
                                    return '&#8709;'.$model->thickness;  
                                } else {
                                    return $model->thickness;  
                                }            
                          },
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => ['style' => 'background-color: white; text-align: center; vertical-align: middle;' ],
           ],
            [
               'header' => '<i class="fa fa-code fa-2x" title="status programming"></i>',
               'attribute' => 'Programming',
               'value' => function(){return '';},
               'filter' => Html::activeDropDownList($searchModel, 'Programming', 
                           [2 => 'on'],['class'=>'form-control', 'prompt' => ' ']),
               'headerOptions' => ['style' => 'min-width: 80px; color: #337ab7; text-align: center;' ],
               'contentOptions' => function($model){
                   $projectAssembliesFiles = new ProjectAssembliesFiles;                   
                   if($projectAssembliesFiles->getFileStatus($model->id, '2')){
                        return ['class' => 'ticked', 'style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                    }
               },
           ],
           [
               'header' => '',
               'attribute' => 'CNC',
               'value' => function(){return '';},
                       'filter' => Html::activeDropDownList($searchModel, 'CNC', 
                           [3 => 'on'],['class'=>'form-control', 'prompt' => ' ']),
               'headerOptions' => ['class' => 'cnc-label', 'style' => 'text-align: center;', 'title' => 'status CNC' ],
               'contentOptions' => function($model){
                   $projectAssembliesFiles = new ProjectAssembliesFiles;
                   if($projectAssembliesFiles->getFileStatus($model->id, '3')){
                        return ['class' => 'ticked', 'style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   }                       
               },
           ],
            [
               'label' => '',
               'attribute' => 'ConvTreat',
               'value' => function(){return '';},
               'filter' => Html::activeDropDownList($searchModel, 'ConvTreat', 
                           [4 => 'on'],['class'=>'form-control', 'prompt' => ' ']),
               'headerOptions' => ['class' => 'ct-label', 'style' => 'text-align: center;', 'title' => 'status conventional treatment'  ],
               'contentOptions' => function($model){
                   $projectAssembliesFiles = new ProjectAssembliesFiles;                   
                   if($projectAssembliesFiles->getFileStatus($model->id, '4')){
                        return ['class' => 'ticked', 'style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                    }
               },
            ],
            [
               'header' => '',
               'attribute' => 'Anodizing',
               'value' => function(){return '';},
               'filter' => Html::activeDropDownList($searchModel, 'Anodizing', 
                           [5 => 'on'],['class'=>'form-control', 'prompt' => ' ']),
               'headerOptions' => ['class' => 'annod-label', 'style' => 'text-align: center;', 'title' => 'status anodizing'  ],
                'contentOptions' => function($model){
                   $projectAssembliesFiles = new ProjectAssembliesFiles;
                   if($projectAssembliesFiles->getFileStatus($model->id, '5')){
                        return ['class' => 'ticked', 'style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   }              
               },
           ],
            [
               'label' => 'Priority',
               'attribute' => 'priority.name',
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', 
                           ArrayHelper::map( FilePriority::find()
                           ->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'priority.name',
               'headerOptions' => ['style' => 'text-align: center; width: 70px' ],
               'contentOptions' => function($model){
               if($model->priorityId == 1){
                   return ['style' => 'background-color:#b9c9fe; color: white;text-align: center; vertical-align: middle;' ];
               } elseif ($model->priorityId == 0){
                   return ['style' => 'background-color:#fdbe87; color: white;text-align: center; vertical-align: middle;' ];
               } else {
                   return ['style' => 'background-color:#fb2d2d; color: white;text-align: center; vertical-align: middle;' ];
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
               }
               
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
               }
           ],
            ['class' => '\kartik\grid\CheckboxColumn',
                   'rowSelectedClass' => 'row-selected',
                   'contentOptions' => ['style' => 'background-color:white; text-align: center; vertical-align: middle;' ],
                ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'background-color:white; '
                                    . 'min-width: 70px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => function(){
                                    return ['style' => 'margin-top: 5px; text-align:center; vartical-align:middle;'];      
                                },
                                'template' => '{seenote} {note} | {downloaddxf} {downloadpdf} <br /> '
                                        . '{add} {deduct} | {sendtreatment} {reject}',                                          
                                'buttons' => [  
                                    'add' => function ()
                                    {
                                        return '<i class="fa fa-plus"></i>';
                                    },
                                    'deduct' => function ()
                                    {
                                        return '<i class="fa fa-minus"></i>';                                        
                                    },
                                    'sendtreatment' => function ()
                                    {
                                        return '<i class="fa fa-paper-plane-o"></i>';
                                    },
                                    'reject' => function ($url, $model)
                                    {                                      
                                        return Html::button( '<a href=""><i class="fa fa-exclamation-triangle"></i></a>', 
                                        ['value' => $url, 'class' => 'reject-button-note', 'id' => 'reject', 
                                        'data-id' => $model->id, 'data-url' => $url, 'title' => 'reject file', 'file-name' => $model->name ] );
                                    },                                    
                                    'seenote' => function ($url, $model)
                                    {
                                    $searchModel = new ProjectAssembliesFilesNotes;
                                    $result = $searchModel->find()
                                            ->andFilterWhere(['fileId' => $model->id])
                                            ->andFilterWhere(['typeId' => 0])
                                            ->all();
                                    
                                    if ($result) {
                                        return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', 
                                        ['value' => $url, 'class' => 'seenote-button', 'id' => 'seenote-button', 
                                         'file-name' => $model->name, 'title' => 'see notes' , 'data' => $model->id] );
                                    } else {
                                        return '<i class="fa fa-file-o"></i>';

                                    }
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', 
                                        ['value' => $url, 'class' => 'cnote-button', 'title' => 'new note', 'file-name' => $model->name ] );
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
                                            ->select(['id'])->where(['projectId' => $model->projectId, 
                                            'name' => $model->name, 'ext' => 'pdf'])->one();
                                            
                                            $fileImage = FilesImages::find()->select(['imagePath'])
                                            ->where(['fileId' => $fileId->id])->one();
                                            
                                                if($fileImage){
                                                    return Html::a( '<span class="fa fa-file-pdf-o"></span>', $url, [
                                                      'data-method' => 'post',
                                                      'title' => Yii::t( 'app', 'download PDF' ),
                                                      'class' => $model->id,
                                                      'image-path' => $fileImage->imagePath,
                                                      'file-name' => $model->name,
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
                                        
                                        $files = ProjectAssembliesFiles::find()
                                                ->andFilterWhere(['and',
                                                 ['=','projectId', $model->projectId],
                                                 ['=','sygnature', $model->sygnature],
                                                 ['=','ext', 'pdf'],      
                                                 ['!=','statusId', '8']
                                                 ])
                                                ->asArray()
                                                ->all();
                                        
                                        if($files){
                                        $url = Url::toRoute( ['project-assemblies-files/download',
                                              'sygnature' => $model->projectId, 'id' => $id, 
                                              'fileSygnature' => $model->sygnature, 'extension' => 'pdf', 'fileName' => $model->name ]);
                                        return $url;
                                        } else {
                                            $url = '';
                                        }
                                    }
                                    if ( $action === 'downloaddxf' )
                                    {
                                        
                                        $files = ProjectAssembliesFiles::find()
                                                ->andFilterWhere(['and',
                                                 ['=','projectId', $model->projectId],
                                                 ['=','sygnature', $model->sygnature],
                                                 ['=','ext', 'dxf'],      
                                                 ['!=','statusId', '8']
                                                 ])
                                                ->asArray()
                                                ->all();
                                        
                                        if($files){
                                        $url = Url::toRoute( ['project-assemblies-files/download',
                                              'sygnature' => $model->projectId, 'id' => $id, 
                                              'fileSygnature' => $model->sygnature, 'extension' => 'dxf', 'fileName' => $model->name ]);
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
                                        $url = Url::toRoute( ['project-assemblies-files-notes/rnote', 'id' => $model->id] );
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
                                    
$this->registerJs("
    //////////////// MODAL ACTIONS
    
    // Create Note action
        $('.cnote-button').click(function(){
        
           var fileName = $(this).attr('file-name');  
           $('.modal-title').append('Note to: ' + fileName); 
        
            $('#modal-window').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });

    // View Note ACtion / change Note Title    
    $('.seenote-button').click(function(){   
    
        var fileName = $(this).attr('file-name');  
        $('.modal-title').append('Notes: ' + fileName);
        
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    
    //REJECT EVENT
    $('.reject-button-note').click(function(){
    
        var fileName = $(this).attr('file-name');
        $('.modal-title').append('Reject element: ' + fileName);  
        
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    
    /////////////// MODAL SETTINGS
    
    // Prevent default timeout redirection behavior
    $(document).on('pjax:timeout', function(event) {
        event.preventDefault()
    });
    
    // Refresh pjax after modal even
    $('#modal-window').on('hidden.bs.modal', function () {
        $('.modal-title').empty();
        $('#modalContent').empty();
        var classCheck =  $('.modal-content').attr('class');
            if(classCheck === 'modal-content pdf-view'){
                $('.modal-content').css('background-image', '');
                $('.modal-content').removeClass('pdf-view');               
             } else {
                 $('.modal-header').css('border-bottom', '1px solid #e5e5e5');
                 $.pjax.reload('#pjax-data');
             }   
    });  
    
    ////////////// OTHER ACTIONS
    
    // Add light effect AND PDF view
    $('.lighted-row').each(function(){  
        $(':lt(11)', this).css('cursor', 'pointer');
        var rowId;
        var imagePath;
        $(this).hover(  
          function() {
                rowId = $(this).attr('data-key');                
                $(this).addClass('light-on-pending');
          }, function() {
                $(this).removeClass('light-on-pending');
          }
        );

        $(':lt(11)', this).click(function(){

            imagePath = $('.' + rowId).attr('image-path');
            if(typeof imagePath != 'undefined'){
                $('#modal-window').modal('show');
                $('.modal-content').css('background-image', 'url(' + imagePath + ')');
                $('.modal-content').addClass('pdf-view');
                $('.modal-header').css('border-bottom', '0');
           }
        }); 
    }); 

    
                    
    // READY FILE EVENT        
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
    
  
    // DEDUCT EVENT
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
    
    // ADD EVENT
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
    
    // MASS ACTION EVENT
    $('.mass-action').click(function(){
       var keys = $('#grid').yiiGridView('getSelectedRows');
       var data = $(this).data('id'); 
       var action = $(this).data('action');
       var url = $(this).data('url');
       var url2 = $(this).data('url2');
           if(keys.length > 0){
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {id: keys, action: action},
                        success: function (data) {

                           if(action === 'download'){
                             var fileLink = data.fileLink;
                             window.location = url2 + '&fileName=' + fileLink;
                           } else {
                             $.pjax.reload('#pjax-data');  
                           }
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
    
    // PAGINATION CHANGE EVENT
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
 
?>
<?php 
    Modal::begin( [
            'id' => 'modal-window',
            'header' => '<h4 class="modal-title"></h4>',
        ] );
        echo "<div id='modalContent'></div>";

    Modal::end();
           
        
    Pjax::end();
?>
</div>
</div>