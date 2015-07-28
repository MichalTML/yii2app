<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actual Clients List';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'clientNumber',
            'name',
            //'adress',
            //'postal',
            'city',
            'phone',
            //'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            'creTime',
            // 'updDate',
            'creUserName',
            //'updUserName',
            // 'contactId',
           
            ['class' => 'yii\grid\ActionColumn',],
            
            ],
    ]); ?>

</div>
