<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectFileData */

$this->title = 'Update Project File Data: ' . ' ' . $model->projectId;
$this->params['breadcrumbs'][] = ['label' => 'Project File Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->projectId, 'url' => ['view', 'id' => $model->projectId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-file-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
