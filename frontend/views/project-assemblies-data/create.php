<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectAssembliesData */

$this->title = 'Create Project Assemblies Data';
$this->params['breadcrumbs'][] = ['label' => 'Project Assemblies Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
