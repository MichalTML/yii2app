<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\FileGroupName */

$this->title = 'Update File Group Name: ' . ' ' . $model->groupId;
$this->params['breadcrumbs'][] = ['label' => 'File Group Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->groupId, 'url' => ['view', 'id' => $model->groupId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-group-name-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
