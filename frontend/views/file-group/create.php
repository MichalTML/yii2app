<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\FileGroup */

$this->title = 'Create File Group';
$this->params['breadcrumbs'][] = ['label' => 'File Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
