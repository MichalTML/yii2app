<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */

$this->title = 'Project: P' . $model->sygnature . '_' . $model->projectName;
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-data-view">
<!--    <h1> Html::encode($this->title) </h1>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sygnature',
            'projectName',            
            'deadline',
             [
                        'label' => 'Status',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'projectStatus0.statusName',
                        'value' => $model->getProjectStatus0Name(),
                        'template' => function ($model){
                                        if($model->getProjectStatus0Name() == 2){
                                        return "<tr><th>{label}</th><td style = 'color: #808080; font-weight: bold; text-align: center; line-height: 2.5em;'>{value}</td></tr>";
                                        } else {                                        
                                        return "<tr><th>{label}</th><td style = 'color: #87cd00; font-weight: bold; text-align: center; line-height: 2.5em;'>{value}</td></tr>";
                                        }
                        }
                    ],
            'client.name', 
            'creUser.username',
            'projectPermissionsUsers',
            'creTime',            
            'updUser.username',
            'updTime',                 
            'endTime',            
        ],
    ]) ?>

</div>
