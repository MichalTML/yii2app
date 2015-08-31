<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
?>
<div class="client-data-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'clientNumber',
            'name',
            'abr',
            'adress',
            'city',
            'postal',
            'phone',
            'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            'www',
            'description',
            'creTime',
            'updTime',
            'creUser.username',
            'updUser.username',
            
            
        ],
    ]) ?>

</div>
