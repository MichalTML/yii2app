<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PermissionHelpers;
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
            'client.name',
            'firstName',
            'lastName',
            [
                'attribute' => 'gender.genderName',
                'value' => 'gender.genderName',
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(\frontend\models\Gender::find()->asArray()->all(), 'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ', 'style' => 'width: 100px;']),
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
                'template' => '{view}{update}{delete}',],
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
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(\frontend\models\Gender::find()->asArray()->all(), 'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ']),
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
                'template' => '{view}',],
        ],
    ]);
   }
   ?>
   

</div>
