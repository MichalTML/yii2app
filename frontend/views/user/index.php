<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Administration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $data = [1 => 'Active', 2 => 'Deleted'];
    
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'username',
        'email:email',
        
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'status_id',
            'value' => 'status.status_name',
            'editableOptions' => [
                'header' => '.',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => $data,
                'options' => ['class'=>'form-control'],
                'editableValueOptions'=>['class'=>'text-info']
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '100px',
        'pageSummary' => false
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'role_id',
            'value' => 'role.role_name',
            'editableOptions' => [
                'header' => '.',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => $data,
                'options' => ['class'=>'form-control'],
                'editableValueOptions'=>['class'=>'text-danger']
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '100px',
        'pageSummary' => false
        ]
     ];   
   
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'export' => FALSE,  
    
    
]);


//    <?= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'username',
//            'email:email',
//            'status_id',
//            'role_id',
//            //'user_type_id',
//            // 'created_at',
//            // 'updated_at',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>

</div>
