<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = 'Create Client Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Client Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
