<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */

$this->title = $model->projectName;
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'You are about to delete: '.$model->projectName.' ,are you sure you want to proceed?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'projectName',            
            'deadline',
            'projectStatus0Name',
            'ClientName', 
            'creUserName',
            'creTime',            
            'updUserName',
            'updTime',                 
            'endTime',            
        ],
    ]) ?>

</div>
