<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectData */

$this->title = 'Create new project';
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'projectPermissions' => $projectPermissions,
    ]) ?>

</div>
