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
            //'updUserName',
            // 'contactId',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                
            
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
           ],
            ],
    ]);
    }
    ?>

        
       
</div>
