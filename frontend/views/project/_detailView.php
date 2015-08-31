<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="datail-view">

    <?php //DetailView::widget([
//        'model' => $model,
//        'template' => "<tr><th style='width:200px; text-align: center;'>{label}</th><td>{value}</td></tr>",
//        'attributes' => [
//            [
//                'label' => '<span style="max-width:100px!important;">Constructors List</span>',
//                'attribute' => 'ProjectPermissionsUsers',
//                'contentOptions' =>['style' => 'max-width:30px'],
//           
//            ],
//            [
//                'label' => $model::getClientName($model->clientId),
//                'attribute' => 'client.clientName' . 'Data',
//                'format' => 'raw',
//                'value' => $model::callClientData($model->clientId),
//            ],
//        ],
//    ]) ?>
    <?= GridView::widget([
     'dataProvider' => new ActiveDataProvider(['query' => $model->getConstructor()]),
        'layout'=>"{items}\n{pager}",
        'rowOptions' => ['style' => 'text-align: center;'],
        'headerRowOptions' => ['style' => 'text-align: center;'],
        'showHeader' => true,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'emptyText' => '<span style="text-align:center">No Constructors found</span>', 
        'emptyTextOptions' => ['style' => 'text-align:center;'],
        'columns' => [
            [
                'header' => '',
                'class' => 'yii\grid\SerialColumn',
                'options' => ['style' => 'width: 20px; text-align: center;'],
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold'],
                
                ],
            [
                'value' => 'user.username',
                'label' => 'Constructor',
                //'contentOptions' => ['style' => 'width:50px'],
                'headerOptions' => ['style' => 'text-align: center']
                
            ],
            [
                'value' => 'firstName',
                'label' => 'First Name',
               // 'contentOptions' => ['style' => 'width:100px'],
                'headerOptions' => ['style' => 'text-align: center']
                
            ],
             [
                'value' => 'lastName',
                'label' => 'Last Name',
                //'contentOptions' => ['style' => 'width:100px'],
                'headerOptions' => ['style' => 'text-align: center']
            ],
        ]
]);
?>
    
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
        'emptyText' => '<span style="text-align:center">No Notes found</span>', 
        'emptyTextOptions' => ['style' => 'text-align:center;'],
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
