<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OClientDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Prospect Clients List';
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-data-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  
    <p>
        <?= Html::a('New Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,  
        'bootstrap' => true,
        'condensed' => true,
            'responsive' => true,
    'hover' => true,
        'columns' => [
            [
                'attribute' => 'status.statusName',
                'value' => 'status.statusName',
                'filter' => Html::activeDropDownList($searchModel, 'status.statusName', ArrayHelper::map(  \frontend\models\OClientDataStatus::find()->asArray()->all(), 'statusName','statusName'),['class'=>'form-control', 'prompt' => ' ']),
],
            'name',
            //'abr',
            // 'adress',
            'city',
            // 'postal',
            'phone',
            // 'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            'www',
            // 'description',
            'creTime',
            'creUser.username',
            // 'updTime',
            // 'updUserId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
