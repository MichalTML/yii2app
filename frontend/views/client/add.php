<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = 'Create New Client';
$this->params['breadcrumbs'][] = ['label' => 'Clients list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_addform', [
        'model' => $model,
        'newClientNumber' => $newClientNumber,
    ]) ?>

</div>
