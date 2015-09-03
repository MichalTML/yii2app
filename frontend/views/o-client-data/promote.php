<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OClientDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Promote Client';
$this->params['breadcrumbs'][] = ['label' => 'Project List', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create project', 'url' => ['project/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promote-index">

    
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
                'label' => 'Status',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'status.statusName',
                'value' => 'status.statusName',
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap; line-height: 2.5em;'],
                'filter' => Html::activeDropDownList($searchModel, 'status.statusName', ArrayHelper::map(  \frontend\models\OClientDataStatus::find()->asArray()->all(), 'statusName','statusName'),['class'=>'form-control', 'prompt' => ' ']),
],
            [
                'label' => 'Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap; line-height: 2.5em;'],
                
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
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'Krs',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'krs',
                'value' => 'krs',
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'Regon',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'regon',
                'value' => 'regon',
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap; line-height: 2.5em;'],
            ],
            [
                'label' => 'Website',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'www',
                'format' => 'url',
                'value' => 'www',
                'contentOptions' => ['target' => 'blank', 'style' => 'white-space: nowrap; text-align: center; line-height: 2.5em;'],
                
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
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => '',
                'headerOptions' => ['style' => 'text-align: center; border-bottom-color: transparent;',
                ],
        ],
            ],
    ]); ?>

</div>
