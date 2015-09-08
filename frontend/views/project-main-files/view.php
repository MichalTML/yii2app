<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectMainFiles */
?>
<div class="project-main-files-view">
    
       <?php 
    echo DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'bootstrap'=>true,
       // 'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'headingOptions' => ['template' => '{title}', 'style' => 'text-align: left;'],
            'heading'=>'<i class="fa fa-cog"></i> '.$model->name,
        ],
        'attributes' => [
            [
                'label' => 'File Size',
                'value' => $model->size,
                'labelColOptions' => ['style' => 'text-align: left; width: 10%'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'File Extension',
                'value' => $model->ext,
                'labelColOptions' => ['style' => 'text-align: left; width: 10%'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Created At',
                'value' => $model->createdAt,
                'labelColOptions' => ['style' => 'text-align: left;; width: 10%'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Updated At',
                'value' => $model->updatedAt,
                'labelColOptions' => ['style' => 'text-align: left; width: 10%'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ]
        ],
    ]);
?>
</div>
