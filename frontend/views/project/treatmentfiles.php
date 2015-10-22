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
use frontend\models\ProjectAssembliesFilesData;

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
            Html::button('<i class="fa fa-check-circle-o fa-2x"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'accept',
                    'type'=>'button', 
                    'title'=> 'accept file', 
                    'class'=>'btn btn-success mass-action'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => 'margin-right: 50px']
            ],
             [
            'content'=>
            Html::button('<i class="fa fa-code fa-2x"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'program',
                    'type'=>'button', 
                    'title'=> 'set status programming', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
            Html::button('', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'cnc',
                    'type'=>'button', 
                    'title'=> 'set status programming', 
                    'class'=>'btn btn-success mass-action cnc'
                ]). ' '.
            Html::button('', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'ct',
                    'type'=>'button', 
                    'title'=> 'set status conventional treatment', 
                    'class'=>'btn btn-success mass-action ct'
                ]).' '.
            Html::button('', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction'] ),
                    'data-action'=>'anodizing',
                    'type'=>'button', 
                    'title'=> 'set status anodizing', 
                    'class'=>'btn btn-success mass-action anod'
                ]),
            'options' => ['class' => 'btn-group-sm', 'style' => 'margin-right: 50px']
            ],
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
            'options' => ['class' => 'btn-group-sm', 'style' => 'margin-right: 50px']
            ],
                 [
            'content'=>
                Html::button('<i class="fa fa-paper-plane"></i>', [
                    'data-url'=>Url::toRoute( ['project-assemblies-files/massaction', 'action' => '2'] ),
                    'data-action'=>'treatfile',
                    'type'=>'button', 
                    'title'=> 'finish element', 
                    'class'=>'btn btn-success mass-action'
                ]). ' '.
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
                return ['style' => 'background-color: #fef7b9; font-size:10px'];
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
               'label' => 'Type',
               'attribute' => 'type.name',
               'filter' => Html::activeDropDownList($searchModel, 'type.name', 
                       ArrayHelper::map(  ProjectAssembliesFilesTypes::find()->asArray()->all(), 
                               'name','name'),['class'=>'form-control', 'prompt' => ' ']),
               'value' => 'type.name',
               'headerOptions' => ['style' => 'text-align: center; min-width: 90px' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
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
               'value' => 'thickness',
               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
               'contentOptions' => ['style' => 'background-color: white; text-align: center; vertical-align: middle;' ],
           ],
//            [
//               'label' => 'Dest.',
//               'attribute' => 'destination.destination',
//               'filter' => Html::activeDropDownList($searchModel, 'destination.destination', ArrayHelper::map(FileDestination::find()->asArray()->all(), 'destination','destination'),['class'=>'form-control', 'prompt' => ' ']),
//               'value' => 'destination.destination',
//               'headerOptions' => ['style' => 'text-align: center; min-width: 70px;' ],
//               'contentOptions' => function($model){
//            if($model->destinationId == 0){
//                return ['style' => 'color: red;text-align: center; vertical-align: middle;' ];
//            } else {
//            return ['style' => 'color:#87cd00; text-align: center; vertical-align: middle;' ];
//               }
//               }
//           ],
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
                        return ['style' => 'background-color: #E6FFB2; color: #87cd00; '
                            . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'background-color: #e6e6e6; color: #87cd00; text-align: '
                            . 'center; vertical-align: middle; white-space: nowrap;' ];
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
                        return ['style' => 'background-color: #E6FFB2; color: #87cd00; '
                            . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'background-color: #e6e6e6; color: #87cd00; '
                            . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
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
                        return ['style' => 'background-color: #E6FFB2; color: #87cd00; '
                            . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'background-color: #e6e6e6; color: #87cd00; '
                       . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
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
                        return ['style' => 'background-color: #E6FFB2; color: #87cd00; '
                            . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   } else {
                        return ['style' => 'background-color: #e6e6e6; color: #87cd00; '
                       . 'text-align: center; vertical-align: middle; white-space: nowrap;' ];
                   }              
               },
           ],
            [
               'label' => 'Priority',
               'attribute' => 'priority.name',
               'filter' => Html::activeDropDownList($searchModel, 'priority.name', ArrayHelper::map( FilePriority::find()->asArray()->all(), 'name','name'),['class'=>'form-control', 'prompt' => ' ']),
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
                                'headerOptions' => ['style' => 'background-color:white; min-width: 70px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => function($model){
                                $fileStatus = ProjectAssembliesFilesData::find()->select(['id'])->where(['fileId' => $model->id, 'statusId' => '1'])->one();
                                if($fileStatus){
                                    return ['style' => 'margin-top: 5px; background-color:#e6ffb2;text-align:center;  line-height: 2.0;' ];
                                }
                                    return ['style' => 'margin-top: 5px; background-color:#E599A3;text-align:center;  line-height: 2.0;' ];      
                                },
                                'template' => '{seenote} {note} | {downloaddxf} {downloadpdf} <br /> {add} {deduct} | {sendtreatment} {reject}',                                          
                                'buttons' => [  
                                    'add' => function ($url, $model)
                                    {
                                    $fileStatus = ProjectAssembliesFilesData::find()->select(['id'])->where(['fileId' => $model->id, 'statusId' => '1'])->one();
                                    if($model->quanityDone == $model->quanity || $fileStatus == null){
                                        return '<i class="fa fa-plus"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-plus"></i></a>', ['value' => $url, 'class' => 'add-button', 'id' => 'add', 'data-id' => $model->id, 'data-url' => $url, 'title' => '+1 ready file' ] );
                                    }},
                                    'deduct' => function ($url, $model){
                                        $fileStatus = ProjectAssembliesFilesData::find()->select(['id'])->where(['fileId' => $model->id, 'statusId' => '1'])->one();
                                    if($model->quanityDone == 0 || $fileStatus == null){
                                        return '<i class="fa fa-minus"></i>';
                                    } else {
                                        return Html::button( '<a href=""><i class="fa fa-minus"></i></a>', ['value' => $url, 'class' => 'deduct-button', 'id' => 'deduct', 'data-id' => $model->id, 'data-url' => $url, 'title' => '-1 ready file' ] );
                                            }},
                                    'sendtreatment' => function ($url, $model)
                                    {
                                                $fileStatus = ProjectAssembliesFilesData::find()->select(['id'])->where(['fileId' => $model->id, 'statusId' => '1'])->one();
                                   if ($model->quanity == $model->quanityDone & $model->destinationId != 0 & $fileStatus != null) {
                                        return Html::button( '<a href=""><i class="fa fa-paper-plane"></i></a>', ['value' => $url, 'class' => 'send-button', 'id' => 'send', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'finish element' ] );
                                    }else{
                                        return '<i class="fa fa-paper-plane-o"></i>';
                                    }
                                    },
                                    'reject' => function ($url, $model)
                                    {                                      
                                        return Html::button( '<a href=""><i class="fa fa-exclamation-triangle"></i></a>', ['value' => $url, 'class' => 'reject-button-note', 'id' => 'reject', 'data-id' => $model->id, 'data-url' => $url, 'title' => 'reject file' ] );
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

        
                        Modal::begin( [
                            'id' => 'rmodal',
                            'header' => '<h4 class="modal-title">New Note</h4>',
                        ] );
                        echo "<div id='modalContent'></div>";

                        Modal::end();
                        
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
    
    $('.reject-button-note').click(function(){
        $('#rmodal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    
    $(document).on('hidden.bs.modal', '#rmodal', function () {
     $.pjax.reload('#pjax-data');
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
       var url2 = $(this).data('url2');
       if(keys.length > 0){
       $.ajax({
       url: url,
       type: 'post',
       data: {id: keys, action: action},
       success: function () {
          if(action === 'download'){
          $.ajax({
            url: url2,
            type: 'POST',
            success: function() {
            window.location = url2;
            }
          });
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