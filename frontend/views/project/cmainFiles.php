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
<?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['container' => 'pjax-container']]); ?>
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
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; line-height: 1em;'],
            ],
           [
               'label' => 'File Name',
               'attribute' => 'name',
               'value' => 'name',
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
               'label' => 'Ext.',
               'attribute' => 'ext',
               'value' => 'ext',
               'headerOptions' => ['style' => 'text-align: center;' ],
               'contentOptions' => ['style' => 'text-align: center; line-height: 1em;' ],
           ],
            
            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 110px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; line-height: 1em;' ],
                                'template' => '{seenote} {note} {download} {view}',
                                'buttons' => [  
                                    'seenote' => function ($url, $model)
                                    {
                                    $searchModel = new ProjectMainFilesNotesSearch();
                                    $searchModel->fileId = $model->id;
                                    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
                                    if ($dataProvider->totalCount > 0) {
                                        return Html::button( '<a href=""><i class="fa fa-file-text"></i></a>', ['value' => $url, 'class' => 'seenote-button', 'id' => 'seenote-button', 'title' => 'see notes' ] );
                                    } else {
                                        return '<i class="fa fa-file-o"></i>';

                                    }
                                    },
                                      
                                    'note' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-file-text-o"></i></a>', ['value' => $url, 'class' => 'note-button', 'id' => 'modalButton', 'title' => 'new note' ] );
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
                                        $url = Url::toRoute( ['project-main-files/download', 'path' => $model->path, 'name' => $model->name , 'sygnature' => $model->projectId, 'id' => $id ]);
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
        Pjax::end();               
