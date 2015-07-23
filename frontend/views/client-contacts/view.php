<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = $model->clientId;
$this->params['breadcrumbs'][] = ['label' => 'Client Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->clientId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->clientId], [
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
            'clientId',
            'firstName',
            'lastName',
            'gender',
            'phone',
            'fax',
            'email:email',
            'department',
            'position',
            'creTime',
            'creUserId',
            'updTime',
            'updUserId',
            'description',
        ],
    ]) ?>

</div>
