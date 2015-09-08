<?php

use kartik\detail\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesFiles */
?>
<div class="project-assemblies-files-view">

     <?php 
        echo DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'bootstrap'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'hideIfEmpty'=>true,
       // 'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'headingOptions' => ['template' => '{title}', 'style' => 'text-align: left;'],
            'heading'=>'<i class="fa fa-cog"></i> '.$model->name,
        ],
        'attributes' => [
           
            [
                'label' => 'Feedback',
                'value' => $model->feedback,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Material',
                'value' => $model->material,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Thickness',
                'value' => $model->thickness,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Status',
                'value' => $model->getStatusName(),
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Type',
                'value' => $model->getTypeName(),
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Size',
                'value' => $model->size,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Quanity',
                'value' => $model->quanity,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Finished',
                'value' => $model->quanityDone,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
             [
                'label' => 'Extension',
                'value' => $model->ext,
                'labelColOptions' => ['style' => 'text-align: left; width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
            [
                'label' => 'Created At',
                'value' => $model->createdAt,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
             [
                'label' => 'Updated At',
                'value' => $model->updatedAt,
                'labelColOptions' => ['style' => 'text-align: left; min-width: 20%; whitespace: nowrap'],
                'valueColOptions'=> ['style'=>'width:65%; text-align: center;']
            ],
        ],
    ]);
?>
</div>

