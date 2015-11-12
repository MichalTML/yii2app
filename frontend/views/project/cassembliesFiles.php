<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use frontend\models\ProjectAssembliesData;
use frontend\models\ProjectAssembliesFilesStatus;
use frontend\models\ProjectAssembliesFilesTypes;
use frontend\models\FilePriority;
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
            Html::button('<i class="fa fa-ban"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/updateele'] ),
                    'data-action'=>'update',
                    'type'=>'button',
                    'data-sygnature'=> $sygnature,
                    'title'=> 'Update Element', 
                    'class'=>'btn btn-success update-action'
                ]),
            'options' => ['class' => 'btn-group-sm btn-group', 'style' => '']
            ],
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
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '6'] ),
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
                                ->Where(['fileId' => $model->id, 'typeId' => 3] )
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
               'format' => 'raw',
               'value' => function($model){
                                if($model->typeId == 5){
                                    return '&#8709;'.$model->thickness;  
                                } else {
                                    return $model->thickness;  
                                }            
                          },
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            [
               'label' => 'Status',
               'attribute' => 'status.statusName',
               'filter' => Html::activeDropDownList($searchModel, 'status.statusName',
                           ArrayHelper::map(  ProjectAssembliesFilesStatus::find()->asArray()->all(), 'statusName','statusName'),
                           ['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'status.statusName',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px;' ],
               'contentOptions' => function ($model) {
                                    if($model->statusId == 6){
                                        return ['style' => 'vertical-align: middle; text-align: center; background-color: #CCF3FF;'];
                                    }elseif ( $model->statusId == 8){
                                        return ['style' => 'vertical-align: middle; text-align: center; background-color: #E6FFB2;'];
                                    }elseif($model->statusId == 9){
                                        return ['style' => 'vertical-align: middle; text-align: center; background-color: #E599A3;'];
                                    }elseif($model->statusId == 1 || $model->statusId == 2 || $model->statusId == 3 || $model->statusId == 4 
                                            || $model->statusId == 5){
                                        return ['style' => 'color: white; vertical-align: middle; text-align: center; background-color: #aac0ee;']; 
                                    }elseif($model->statusId == 10){
                                        return ['style' => 'color: white; vertical-align: middle; text-align: center; background-color: #394b58;'];
                                    }else{
                                        return ['style' => 'vertical-align: middle; text-align: center; background-color: white;']; 
                                    }               
                                },
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
                    'contentOptions' => function($model){
                                        $notesCheck = ProjectAssembliesFilesNotes::find()
                                                     ->Where(['fileId' => $model->id, 'typeId' => 3, 'statusId' => 0] )
                                                     ->all();
                                        if($notesCheck){
                                           return ['style' => 'background-color: #fb2d2d;', 
                                                'file-status' => $model->statusId, 'class' => $model->id]; 
                                        }
                                        return ['style' => 'background-color: white;', 
                                                'file-status' => $model->statusId, 'class' => $model->id];
                                        }
                ],
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'background-color:white; min-width: 70px; text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => function($model){   
                                                    $notesCheck = ProjectAssembliesFilesNotes::find()
                                                                ->select(['id'])
                                                                ->where(['fileId' => $model->id, 
                                                                 'typeId' => 2, 'creUserId' => Yii::$app->user->id])
                                                                ->all();
                                                    if($notesCheck){
                                                        return ['style' => 'background-color: #b9c9fe;margin-top: 5px; text-align:center; vertical-align:middle' ];     
                                                    }
                                                    return ['style' => 'margin-top: 5px; text-align:center; vertical-align:middle' ];      
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
                                            return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', 
                                                   ['file-name' => $model->name, 'value' => $url, 'class' => 'seenote-button', 
                                                   'id' => 'seenote-button', 'title' => 'new personal note' , 'data' => $model->id] );
                                    },
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', 
                                               ['value' => $url, 'class' => 'cnote-button', 
                                               'title' => 'new note', 'file-name' => $model->name] );
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
                                            $fileImagePath = '';
                                            $fileId = ProjectAssembliesFiles::find()
                                            ->select(['id'])->where(['projectId' => $model->projectId, 
                                             'sygnature' => $model->sygnature, 'ext' => 'pdf'])->one();
                            
                                           if($fileId){
                                                $fileImage = FilesImages::find()
                                                            ->select(['imagePath'])->where(['fileId' => $fileId->id])->one();
                                                if($fileImage){
                                                  $fileImagePath = $fileImage->imagePath;  
                                                }           
                                           } 
                                                if($fileId){
                                                    return Html::a( '<span class="fa fa-file-pdf-o"></span>', $url, [
                                                      'data-method' => 'post',
                                                      'title' => Yii::t( 'app', 'download PDF' ),
                                                      'class' => $model->id,
                                                      'image-path' => $fileImagePath,
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
                                        $url = Url::toRoute( ['project-assemblies-files-notes/note',
                                                   'id' => $model->id, 'filter' => 'constructor' ] );
                                        return $url;
                                    }
                                     if ( $action === 'seenote' )
                                    {
                                        $url = Url::toRoute( ['project-assemblies-files-notes/privnote', 
                                            'id' => $model->id, 'filter' => 'privnote' ] );
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
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var classCheck =  $('.modal-content', this).attr('class');
        $('.modal-title').empty();
        $('#modalContent').empty();
            if(classCheck === 'modal-content pdf-view'){
                $('.modal-content').css('background-image', '');
                $('.modal-content').removeClass('pdf-view'); 
             } else {
                 $('.modal-header').css('border-bottom', '1px solid #e5e5e5');
                 $.pjax.reload('#pjax-data');
                 $(document).one('ajaxStop', function() {
                    if(keys.length > 0){

                       for( var x = 0; x < keys.length; x++){
                           $('input[value=' + keys[x] + ']').prop('checked', false);
                           $('input[value=' + keys[x] + ']').prop('checked', true);  
                       }
                    }
                });
            }   
    });  
    
    $('#update-modal-window').on('hidden.bs.modal', function () {
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var classCheck =  $('.modal-content', this).attr('class');
        $('.modal-title').empty();
        $('#modalContent').empty();
            if(classCheck === 'modal-content pdf-view'){
                $('.modal-content').css('background-image', '');
                $('.modal-content').removeClass('pdf-view');  
                
             } else {
                 $('.modal-header').css('border-bottom', '1px solid #e5e5e5');
                 $.pjax.reload('#pjax-data');
                 $(document).one('ajaxStop', function() {
                    if(keys.length > 0){

                       for( var x = 0; x < keys.length; x++){
                           $('input[value=' + keys[x] + ']').prop('checked', false);
                           $('input[value=' + keys[x] + ']').prop('checked', true);  
                       }
                    }
                });
            }   
    }); 
    
    ///////////////// MODAL EVENTS
    
    // UPDATE ELEMENT ACTION
    $('.update-action').click(function(){
           var keys = $('#grid').yiiGridView('getSelectedRows');
           var fileId = keys[0];
           var statusId = $('.' + keys[0]).attr('file-status');
           console.log(statusId);
           
           if(statusId == 0 || statusId == 3){
                var fileName = $('tr[data-key=\\'' + fileId + '\\'] .cnote-button').attr('file-name');  
                var url = $(this).data('url');
                var sygnature = $(this).data('sygnature');
                var url2 = url + '&sygnature=' + sygnature + '&id=' + fileId;
                     if(keys.length > 0){   
                         $('#update-modal-window').modal('show')
                             .find('#modalContent')
                             .load(url2);      
                         $('.modal-title').empty();
                         $('.modal-title').append('Element: ' + fileName);  

                     }
            }
                
              
       
    });
    
    // get the click event of the Note button
    $('.cnote-button').click(function(){
        var fileName = $(this).attr('file-name');
        $('.modal-title').empty();
        $('.modal-title').append('Note to: ' + fileName);
        
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
                
    });
    
    // View Note ACtion / change Note Title    
    $('.seenote-button').click(function(){
        var fileName = $(this).attr('file-name');
        $('.modal-title').empty();
        $('.modal-title').append('Notes: ' + fileName);
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
        var fileName;
        $(this).hover(  
          function() {
                rowId = $(this).attr('data-key');                
                $(this).addClass('light-on-treatment');
          }, function() {
                $(this).removeClass('light-on-treatment');
          }
        );

        $(':lt(11)', this).click(function(){
            fileName = $('a.' + rowId).attr('file-name');
            imagePath = $('a.' + rowId).attr('image-path');
            if(typeof imagePath != 'undefined'){
                $('#modal-window').modal('show');
                $('.modal-title').empty();
                $('.modal-title').append('Eelement: ' + fileName);
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
");                          

    Pjax::end();

    Modal::begin( [
            'id' => 'modal-window',
            'header' => '<h4 class="modal-title"></h4>',
    ] );
        
    echo "<div id='modalContent'></div>";

   Modal::end();
   
   Modal::begin( [
            'id' => 'update-modal-window',
            'size' => Modal::SIZE_LARGE,
            'header' => '<h4 class="modal-title"></h4>',
    ] );
        
    echo "<div id='modalContent'></div>";

   Modal::end();

?>

</div>