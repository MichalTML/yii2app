<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesFiles */

$this->title = 'Create Project Assemblies Files';
$this->params['breadcrumbs'][] = ['label' => 'Project Assemblies Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
