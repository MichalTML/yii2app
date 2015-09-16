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

    <p>
        <?php if($model->projectStatus !== 2){?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'You are about to delete: '.$model->projectName.' ,are you sure you want to proceed?',
                'method' => 'post',
            ],
        ]); }?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sygnature',
            'projectName',            
            'deadline',
            'projectStatus0.statusName',
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
