<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="datail-view" style="background: silver">

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'First Name',
                'attribute' => 'profile.firstName',              
            ],
            [
                'label' => 'Last Name',
                'attribute' => 'profile.lastName',              
            ],
            [
                'label' => 'Birth Date',
                'attribute' => 'profile.birthdate',              
            ],
            [
                'label' => 'Gender',
                'attribute' => 'profile.gender.genderName',             
            ],
            [
                'label' => 'Created at',
                'attribute' => 'created_at',            
            ],
            [
                'label' => 'Updated at',
                'attribute' => 'updated_at',          
            ],
            
            
        ],
    ]) ?>
  
 
    

</div>
