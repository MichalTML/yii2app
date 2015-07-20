<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */

$this->title = $model->projectId.'-'.$model->projectName;
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
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'projectId',
            'projectName',
            'deadline',
            'constructorId',
            'projectStatus',
            'clientData.name',
            'user.firstlastName',
            'creDate',  
            'updUser',
            'updDate',                 
            'endDate',            
        ],
    ]) ?>

</div>
