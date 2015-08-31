<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectFileData */

$this->title = 'Create Project File Data';
$this->params['breadcrumbs'][] = ['label' => 'Project File Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-file-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
