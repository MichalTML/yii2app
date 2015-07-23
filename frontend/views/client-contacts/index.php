<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Client Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clientId',
            'firstName',
            'lastName',
            'gender',
            'phone',
            // 'fax',
            // 'email:email',
            // 'department',
            // 'position',
            // 'creTime',
            // 'creUserId',
            // 'updTime',
            // 'updUserId',
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
