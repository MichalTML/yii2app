<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OClientDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Prospect Clients List';
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  
    <p>
        <?= Html::a('Create Oclient Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'statusName',
            'name',
            //'abr',
            // 'adress',
            // 'city',
            // 'postal',
            'phone',
            // 'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            // 'www',
            // 'description',
            'creTime',
            'creUserName',
            // 'updTime',
            // 'updUserId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
