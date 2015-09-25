<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = 'Update Client: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Actual Clients List', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Client: '. $model->name;
?>
<div class="client-data-update">

   

    <?= $this->render('_form', [
        'model' => $model,
        'newClientNumber' => $newClientNumber,
    ]) ?>

</div>
