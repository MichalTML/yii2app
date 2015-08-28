<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */

$this->title = 'Update Project Notes: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Project Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'projectId' => $model->projectId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-notes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
