<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\models\ProjectData;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects list';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>

<div class="project-treatment-data-index">

    <?=
    GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => false,
        'headerRowOptions' => ['style' => 'font-size: 12px'],
        'rowOptions' => function ($model)
                        {
                        return ['class' => 'treatment-row' ,'style' => 'font-size: 14px; background-color:#808080; height: 50px; border-bottom: 2px solid white'];
                        },
                'columns' => [
                    [
                        'label' => 'Project Nr',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'sygnature',
                        'value' => 'sygnature',
                        'filter' => Html::activeDropDownList( $searchModel, 'sygnature', 
                        ProjectData::getSygnatures(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                        'contentOptions' => ['class' => '', 'style' => 'padding-left: 10px; text-align: left; vertical-align: middle; color: white;' ],
                    ],
                    [
                        'label' => 'Project Name',
                        'attribute' => 'projectName',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'padding-left: 10px; text-align: left; vertical-align: middle; white-space: nowrap; color:white' ]
                    ],                    
                    [
                        'label' => 'Elements ',
                        'attribute' => 'Elements Count',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'format' => 'raw',
                        'value' => function($model){
                        return ProjectData::getElemenetsList($model->sygnature);
                        },
                        'contentOptions' => ['style' => 'background-color:#e6e6e6; text-align: center; vertical-align: middle;' ],
                    ],
                    [
                        'label' => 'Low ',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'Low Priority',
                        'format' => 'raw',
                        'value' => function($model){
                        return ProjectData::getElemenetsList($model->sygnature, 'low');
                        },
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle; background-color: #E8A54A; color: white' ],
                    ],
                    [
                        'label' => 'Normal',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'Normal Priority',
                        'format' => 'raw',
                        'value' => function($model){
                        return ProjectData::getElemenetsList($model->sygnature, 'normal');
                        },
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle; background-color: #1182FF; color: white;' ],
                    ],
                    [
                        'label' => 'High',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'High Priority',
                        'format' => 'raw',
                        'value' => function($model){
                        return ProjectData::getElemenetsList($model->sygnature, 'high');
                        },
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle; background-color: #FF6436; color: white;' ],
                    ],           
                        
                     ],          
                            ] );
?>
</div>