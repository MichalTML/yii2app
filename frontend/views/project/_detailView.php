<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

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
            ]
        ],
    ]) ?>
  
 
    

</div>
