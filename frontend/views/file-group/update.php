<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\FileGroup */

$this->title = 'Update File Group: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'File Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
