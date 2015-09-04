<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectMainFiles */

$this->title = 'Create Project Main Files';
$this->params['breadcrumbs'][] = ['label' => 'Project Main Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-main-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
