<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */

$this->title = 'Update Project ' . ' P'.$model->sygnature.'_'.$model->projectName;
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update project: P' . $model->sygnature . '_' . $model->projectName;
?>
<div class="project-data-update">

<!--    <h1> Html::encode($this->title) </h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'projectPermissions' => $projectPermissions,
        'freeId' => $freeId
    ]) ?>

</div>
