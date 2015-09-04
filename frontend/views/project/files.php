<?php

use kartik\grid\GridView;
use kartik\grid\ExpandRowColumn;
use frontend\models\ProjectMainFiles;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'P'.$project->sygnature.'_'.$project->projectName.' Technical Documentation';
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<br />

 <?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'summary'=>"",
        'headerRowOptions' => ['style' => 'display:none'],
             'columns' => [
                 [
                     'format' => 'html',
                     'contentOptions' => ['style' => 'text-align: center'],
                     'value' => function ($data) {
                        return '<b>Project Main Technical Documentation Files</b>';
                 },
                 ],
                 
                   [
          'class'=>'kartik\grid\ExpandRowColumn',
          'enableRowClick'=>true,
          'width'=>'200px',
          'value'=>function ($model, $key, $index, $column) {
              return GridView::ROW_COLLAPSED;
          },
          'detail'=>function ($model, $key, $index, $column) {
              return 'hello world';//Yii::$app->controller->renderPartial('_expand-row-details', ['model'=>$model]);
          },
          'detailAnimationDuration'=>100,
          'expandIcon'=>'<span class="fa fa-angle-right"></span>',
          'collapseIcon'=>'<span class="fa fa-angle-down"></span>',
          //'headerOptions'=>['class'=>'kartik-sheet-style']          
        ],  
                 ]
                
    
    
    
    
]);
    
echo GridView::widget([
    'dataProvider' => $dataProvider,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'summary'=>"",
        'headerRowOptions' => ['style' => 'display:none'],
             'columns' => [
                 [
                     'format' => 'html',
                     'contentOptions' => ['style' => 'text-align: center'],
                     'value' => function ($data) {
                        return '<b>Project Main Technical Documentation Files</b>';
                 },
                 ],
                 
                   [
          'class'=>'kartik\grid\ExpandRowColumn',
          'enableRowClick'=>true,
          'width'=>'200px',
          'value'=>function ($model, $key, $index, $column) {
              return GridView::ROW_COLLAPSED;
          },
          'detail'=>function ($model, $key, $index, $column) {
              return 'hello world';//Yii::$app->controller->renderPartial('_expand-row-details', ['model'=>$model]);
          },
          'detailAnimationDuration'=>100,
          'expandIcon'=>'<span class="fa fa-angle-right"></span>',
          'collapseIcon'=>'<span class="fa fa-angle-down"></span>',
          //'headerOptions'=>['class'=>'kartik-sheet-style']          
        ],  
                 ]
                
    
    
    
    
]);
    
    
    
