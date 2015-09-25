<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = 'Update Contact';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Client Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update contact: ' . $model->firstName . ' ' . $model->lastName;
?>
<div class="client-contacts-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
