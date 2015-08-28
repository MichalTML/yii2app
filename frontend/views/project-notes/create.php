<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */

$this->title = 'Create Project Notes';
$this->params['breadcrumbs'][] = ['label' => 'Project Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-notes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
