<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="datail-view">

    <?= DetailView::widget([
        'model' => $model,
        'template' => "<tr><th style='width:200px; text-align: center;'>{label}</th><td>{value}</td></tr>",
        'attributes' => [
            [
                'label' => '<span style="max-width:100px!important;">Constructors List</span>',
                'attribute' => 'ProjectPermissionsUsers',
                'contentOptions' =>['style' => 'max-width:30px'],
           
            ],
            [
                'label' => $model::getClientName($model->clientId),
                'attribute' => 'client.clientName' . 'Data',
                'format' => 'raw',
                'value' => $model::callClientData($model->clientId),
            ],
        ],
    ]) ?>
    
    <?= GridView::widget([
     'dataProvider' => new ActiveDataProvider(['query' => $model->getNote(), 'sort'=> ['defaultOrder' => ['creTime'=>SORT_DESC]] ]),
        'layout'=>"{items}\n{pager}",
        'rowOptions' => ['style' => 'text-align: center;'],
        'showHeader' => false,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'emptyText' => '',
        'columns' => [
            [
                'value' => 'title',
                'label' => 'Title',
                'contentOptions' => ['style' => 'width:50px']
                
            ],
[
                'value' => 'note',
                'label' => 'Note Content',
                'contentOptions' => ['style' => 'width:400px']
                
            ],
            [
                'value' => 'creUser.username',
                'label' => 'Created by',
                'contentOptions' => ['style' => 'width:50px']
                
            ],
            [
                'value' => 'creTime',
                'label' => 'Created at',
                'contentOptions' => ['style' => 'width:50px']
                
            ],
           
            
            
        ]
]);
?>

  
 
    

</div>
