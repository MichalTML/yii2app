<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Client Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'clientNumber',
            'name',
            'abr',
            'adress',
            // 'phone',
            // 'fax',
            // 'email:email',
            // 'nip',
            // 'krs',
            // 'regon',
            // 'www',
            // 'creDate',
            // 'updDate',
            // 'creUserId',
            // 'updUserId',
            // 'contactId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
