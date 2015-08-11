<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OClientData */

$this->title = 'Update client: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-data-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
