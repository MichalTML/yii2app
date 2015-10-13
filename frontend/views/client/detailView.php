<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
?>

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
