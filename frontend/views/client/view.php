<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'clientNumber',
            'name',
            'abr',
            'adress',
            'postal',
            'city',
            'phone',
            'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            'www',
            'creDate',
            'updDate',
            'creUserId',
            'updUserId',
            'description',
            'contactId',
        ],
    ]) ?>

</div>
