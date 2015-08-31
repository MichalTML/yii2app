<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectFileData */

$this->title = $model->projectId;
$this->params['breadcrumbs'][] = ['label' => 'Project File Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-file-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->projectId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->projectId], [
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
            'path',
            'root',
            'files',
            'createdAt',
            'assembliesMainFiles',
            'projectMainFiles',
            'assembliesFiles',
        ],
    ]) ?>

</div>
