<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'summary'=>"",
        'headerRowOptions' => ['style' => 'display:none'],
             'columns' => [
                'projectId',
                 
                  
                 ]
                
    
    
    
    
]);
  
 
 
