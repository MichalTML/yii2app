<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesFilesNotes */

$this->title = 'Create Project Assemblies Files Notes';
$this->params['breadcrumbs'][] = ['label' => 'Project Assemblies Files Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-files-notes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
