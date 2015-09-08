<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesMainFiles */

$this->title = 'Create Project Assemblies Main Files';
$this->params['breadcrumbs'][] = ['label' => 'Project Assemblies Main Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-main-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
