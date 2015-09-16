<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectMainFilesNotes */

$this->title = 'Update Project Main Files Notes: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Project Main Files Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-main-files-notes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
