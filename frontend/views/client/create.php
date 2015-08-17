<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = 'Create New Client';
$this->params['breadcrumbs'][] = ['label' => 'Clients list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-create">

    <?= $this->render('_form', [
        'model' => $model,
        'newClientNumber' => $newClientNumber,
    ]) ?>

</div>
