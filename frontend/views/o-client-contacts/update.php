<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OClientContacts */

$this->title = 'Update Contact';
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Clients Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-contacts-update">

 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
