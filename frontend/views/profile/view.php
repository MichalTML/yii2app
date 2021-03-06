<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = $model->user->username . "'s Profile";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="profile-view">

<?php
    //this is not necessary but in here as example
    
    if(PermissionHelpers::userMustBeOwner('profile', $model->id)) {
        
        echo Html::a('Update', ['update', 'id' => $model->id],
                               ['class' => 'btn btn-info']);        
    }?>
    
    <?php // Html::a('Delete', ['delete', 'id' => $model->id], [
//        'class' => 'btn btn-danger',
//        'data' => [
//            'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
//            'method' => 'post',
//        ],
//        ]); ?>
    
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'user.username',
            'firstName',
            'lastName',
            'userEmail',
            'birthdate',
            'gender.genderName',
            'created',
            'updated',
            'user.last_log',
            //'user_id',
        ],
    ]) ?>

</div>
