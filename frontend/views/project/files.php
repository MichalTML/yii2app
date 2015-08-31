<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="datail-view">
<?php    //var_dump($projectFilesData);die(); ?>
<?php
$attributes = [
    [
        'group'=>true,
        'label'=>'SECTION 1: Identification Information',
        'rowOptions'=>['class'=>'info']
    ],
    'column' => [
        'attribute' => 'projectId',
        'label' => 'Project Id',
    ]
                        ]
 ?>
 <?php
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
//    'bordered' => $bordered,
//    'striped' => $striped,
//    'condensed' => $condensed,
//    'responsive' => $responsive,
//    'hover' => $hover,
//    'hAlign'=>$hAlign,
//    'vAlign'=>$vAlign,
//    'fadeDelay'=>$fadeDelay,
    'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' => 1000, 'kvdelete'=>true],
    ],
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);
 ?>

  
 
    

</div>
