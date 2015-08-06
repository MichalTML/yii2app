<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\OClientContacts */

$this->title = 'Create Contact';
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Clients List', 'url' => ['o-client-data/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create Client', 'url' => ['o-client-data/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_addform', [
        'model' => $model,
    ]) ?>

</div>
