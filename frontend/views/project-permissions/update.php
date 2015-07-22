<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectPermissions */

$this->title = 'Update Project Permissions: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Project Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-permissions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
