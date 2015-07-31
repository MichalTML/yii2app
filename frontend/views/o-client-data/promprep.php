<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OClientData */

$this->title = 'Promote Client: '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project List', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create new project', 'url' => ['project/create']];
$this->params['breadcrumbs'][] = ['label' => 'Promote Client', 'url' => ['o-client-data/promote']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_prom', [
        'model' => $model,
        'newClientNumber' => $newClientNumber,
    ]) ?>

</div>
