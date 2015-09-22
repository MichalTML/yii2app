<?php

use kartik\grid\GridView;
use frontend\models\search\ProjectMainFilesSearch;
use frontend\models\search\ProjectAssembliesMainFilesSearch;
use frontend\models\search\ProjectAssembliesFilesSearch;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'P' . $project->sygnature . '_' . $project->projectName . ' Technical Documentation';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Project list', 'url' => ['fileindex' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<br />

<?php
echo GridView::widget( [
    'dataProvider' => $dataProvider,
    'export' => FALSE,
    'bootstrap' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'summary' => "",
    'headerRowOptions' => ['style' => 'display:none' ],
    'columns' => [
        [
            'format' => 'html',
            'contentOptions' => ['style' => 'text-align: left; padding-left: 50px' ],
            'value' => function ($data, $model)
    {
        return '<b>' . $this->title . '</b> | Creation Time: ' . $data->createdAt;
    },
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'enableRowClick' => true,
            'width' => '400px',
            'value' => function ($model, $key, $index, $column)
            {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($data) use ($project)
            {
                $searchModel = new ProjectMainFilesSearch();
                $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $data->projectId );
                $id = $project->id;
                return $this->render( 'cmainFiles', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'id' => $id,
                        ] );
            },
                    'detailAnimationDuration' => 100,
                    'expandIcon' => '<span class="fa fa-angle-right"></span>',
                    'collapseIcon' => '<span class="fa fa-angle-down"></span>',
                //'headerOptions'=>['class'=>'kartik-sheet-style']          
                ],
            ]
        ] );

        echo GridView::widget( [
            'dataProvider' => $assemblieData,
            'export' => FALSE,
            'bootstrap' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'summary' => "",
            'headerRowOptions' => ['style' => 'display:none' ],
            'columns' => [
                [
                    'format' => 'html',
                    'contentOptions' => ['style' => 'text-align: left; padding-left: 50px' ],
                    'value' => function ($data)
            {
                $id = preg_replace( '/' . $data->projectId . '/', '', $data->id );
                $name = implode( ' ', explode( '_', $data->name ) );
                return '<b>Mechanism :</b> ' . $id . ' | ' . $name;
            },
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'enableRowClick' => true,
                    'width' => '400px',
                    'expandOneOnly' => true,
                    'value' => function ($model, $key, $index, $column)
                    {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($data) use ($project)
                    {
                        $searchModel = new ProjectAssembliesMainFilesSearch();
                        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $data->id );
                        $id = $project->id;
                        return $this->render( 'assemblyMainFiles', [
                                    'searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'id' => $id,
                                ] );
                    },
                            'detailAnimationDuration' => 100,
                            'expandIcon' => '<span class="fa fa-angle-right"></span>',
                            'collapseIcon' => '<span class="fa fa-angle-down"></span>',
                        //'headerOptions'=>['class'=>'kartik-sheet-style']          
                        ],
                    ]
                ] );

                echo GridView::widget( [
                    'dataProvider' => $dataProvider,
                    'export' => FALSE,
                    'bootstrap' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'summary' => "",
                    'headerRowOptions' => ['style' => 'display:none' ],
                    'columns' => [
                        [
                            'format' => 'html',
                            'contentOptions' => ['style' => 'text-align: left; padding-left: 50px' ],
                            'value' => function ($data, $model)
                    {
                        return '<b>' . $this->title . '</b> | Files';
                    },
                        ],
                        [
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'enableRowClick' => true,
                            'width' => '400px',
                            'value' => function ($model, $key, $index, $column)
                            {
                                return GridView::ROW_COLLAPSED;
                            },
                            'detail'=>function ($data) use ($project) {
              $searchModel = new ProjectAssembliesFilesSearch();
              $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $data->projectId);
              $id = $project->id;
              $sygnature = $project->sygnature;
         return $this->render( 'vassembliesFiles', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,  
                    'id' => $id,
                    'sygnature' => $sygnature,
                ] );
          },
                                    'detailAnimationDuration' => 100,
                                    'expandIcon' => '<span class="fa fa-angle-right"></span>',
                                    'collapseIcon' => '<span class="fa fa-angle-down"></span>',
                                //'headerOptions'=>['class'=>'kartik-sheet-style']          
                                ],
                            ]
                        ] );
                        Modal::begin( [
                            'id' => 'file-modal',
                            'closeButton' => false,
                            'headerOptions' => ['style' => 'display:none' ],
                        ] );
                        echo "<div id='modalContent'></div>";
                        Modal::end();

                        Modal::begin( [
                            'id' => 'modal',
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



                        