<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\models\search\ProjectMainFilesNotesSearch;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="project-data-index">
<?php Pjax::begin(['id' => 'pjax-data-project-main']); ?>
    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'summary' => "",
        'rowOptions' => ['style' => 'font-size:12px'],
        'headerRowOptions' => ['style' => 'font-size:12px'],
        'filterRowOptions' => ['style' => 'max-height: 10px'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; vertical-align: middle;'],
            ],
           [
               'label' => 'File Name',
               'attribute' => 'name',
               'value' => 'name',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
           [
               'label' => 'Ext.',
               'attribute' => 'ext',
               'value' => 'ext',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
           ],
            
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;' ],
                                'template' => '{seenote} {note} {download} {view}',
                                'buttons' => [  
                                    'seenote' => function ($url, $model)
                                    {
                                    $searchModel = new ProjectMainFilesNotesSearch();
                                    $searchModel->fileId = $model->id;
                                    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
                                    if ($dataProvider->totalCount > 0) {
                                        return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', 
                                              ['file-name' => $model->name, 'value' => $url, 'class' => 'seenote-button', 
                                              'id' => 'seenote-button', 'title' => 'see notes' ] );
                                    } else {
                                        return '<i class="fa fa-file-o"></i>';

                                    }
                                    },
                                      
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', 
                                               ['file-name' => $model->name, 'value' => $url, 'class' => 'note-button', 
                                                'id' => 'note-button', 'title' => 'new note' ] );
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
                                        return Html::button( '<a href=""><i class="glyphicon glyphicon-eye-open"></i></a>', 
                                               ['value' => $url, 'class' => 'file-details', 'id' => 'file-details', 
                                                'file-name' => $model->name, 'title' => 'file details' ] );
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) use ($id) 
                                {
                                    if ( $action === 'download' )
                                    {
                                        $url = Url::toRoute( ['project-main-files/download', 'path' => $model->path, 
                                              'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
                                        return $url;
                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['project-main-files/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'note' )
                                    {
                                        $url = Url::toRoute( ['project-main-files-notes/note', 'id' => $model->id ] );
                                        return $url;
                                    }
                                     if ( $action === 'seenote' )
                                    {
                                        $url = Url::toRoute( ['project-main-files-notes/view', 'id' => $model->id ] );
                                        return $url;
                                    }
                                } 
                                
                                    ],
            ]
        ]);  
$this->registerJS("
/////////////// MODAL SETTINGS   
   
    // Refresh pjax after modal even
    $('#modal-window').on('hidden.bs.modal', function () {
            if(action === 'file-details' || action === 'file-details-a'){             
             } else {
                 $('.modal-header').css('border-bottom', '1px solid #e5e5e5');
                 $.pjax.reload('#pjax-data-project-main');
             }   
    }); 

 // Prevent default timeout redirection behavior
    $(document).on('pjax:timeout', function(event) {
        event.preventDefault()
    });
    
    // View File Details
    $('.file-details').click(function(){
        action = $(this).attr('id');
        var fileName = $(this).attr('file-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('File: ' + fileName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    // get the click event of the Note button
    $('.note-button').click(function(){
        action = $(this).attr('id');
        var fileName = $(this).attr('file-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('Note to: ' + fileName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

     $('.seenote-button').click(function(){
        action = $(this).attr('id');
        var fileName = $(this).attr('file-name');
        $('#modal-window .modal-title').empty();
        $('#modal-window .modal-title').append('Notes: ' + fileName);
        $('#modal-window').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

");

        Pjax::end();  
