<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectMainFilesNotes */

$this->title = 'Create Project Main Files Notes';
$this->params['breadcrumbs'][] = ['label' => 'Project Main Files Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-main-files-notes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
