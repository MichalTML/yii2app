<?php

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

?>
<div class="datail-view">

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
