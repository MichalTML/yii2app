<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients List';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('New Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    if(PermissionHelpers::requireMinimumPower(Yii::$app->user->identity->id) > 30){
        
    echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,  
    'bootstrap' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
        
        'columns' => [
            [
                'label' => 'Client Number',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'clientNumber',
                'value' => 'clientNumber',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'City',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'city',
                'value' => 'city',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Phone',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'phone',
                'value' => 'phone',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Email',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'email',
                'format' => 'email',
                'value' => 'email',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Nip',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'nip',
                'value' => 'nip',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Krs',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'krs',
                'value' => 'krs',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Regon',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'regon',
                'value' => 'regon',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
            ],
            [
                'label' => 'Created At',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creTime',
                'value' => 'creTime',
                'contentOptions' => ['style' => 'text-align: center; line-height: 1.5em;'],
            ],
            [
                'label' => 'Created By',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creUser.username',
                'value' => 'creUser.username',
                'contentOptions' => ['style' => 'text-align: center; line-height: 1.5em;'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => '',
                'headerOptions' => ['style' => 'text-align: center; border-bottom-color: transparent;' ],
            ],
            ],
    ]);  
       
    } else {
        
    echo GridView::widget([
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
            'creUser.username',
            //'creUserName',
            //'updUserName',
            // 'contactId',
           ['class' => 'yii\grid\ActionColumn',
               'template' => '{view}',
               'header' => '',
               'headerOptions' => ['style' => 'text-align: center; border-bottom-color: transparent;' ],
           ],
            ],
    ]);
    }
    ?>

        
       
</div>
