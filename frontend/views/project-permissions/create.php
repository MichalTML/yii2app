<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectPermissions */

$this->title = 'Create Project Permissions';
$this->params['breadcrumbs'][] = ['label' => 'Project Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-permissions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
