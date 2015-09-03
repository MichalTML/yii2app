<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PermissionHelpers;
use frontend\models\Gender;
use yii\helpers\ArrayHelper;
use frontend\models\ClientContacts;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('New Contact', ['create'], ['class' => 'btn btn-success']) ?>
    </p> 
   <?php
   $ClientContacts = new ClientContacts;
   if(PermissionHelpers::requireMinimumPower(Yii::$app->user->identity->id) > 30){
   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       'export' => FALSE,  
    'bootstrap' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
        
        'columns' => [
            [
                'label' => 'Client Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'client.name',
                'value' => 'client.name',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'First Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'firstName',
                'value' => 'firstName',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
             [
                'label' => 'Last Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'lastName',
                'value' => 'lastName',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            
            [
                'label' => 'Gender',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'gender.genderName',
                'value' => 'gender.genderName',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(Gender::find()->asArray()->all(),
                'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ', 'style' => 'width: 100px;']),
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
                'label' => 'Department',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'department',
                'value' => 'department',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
            [
                'label' => 'Position',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'position',
                'value' => 'position',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
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

            'client.name',
            'firstName',
            'lastName',
            [
                'attribute' => 'gender.genderName',
                'value' => 'gender.genderName',
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(Gender::find()->asArray()->all(),
                'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ']),
            ],
            'phone',
            // 'fax',
             'email:email',
            'department',
            'position',
            'creUser.username',
            'creTime',
            //'creUserId',
            // 'updTime',
            // 'updUserId',
            // 'description',

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
