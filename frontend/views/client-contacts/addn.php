<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = 'Create Contact';
$this->params['breadcrumbs'][] = ['label' => 'Clients list', 'url' => ['client/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create New Client', 'url' => ['client/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_addform', [
        'model' => $model,
    ]) ?>

</div>
