<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="client-contacts-view">

    <?=
    DetailView::widget( [
        'model' => $model,
        'attributes' => [
            'client.name',
            'firstName',
            'lastName',
            'gender.genderName',
            'phone',
            'fax',
            'email:email',
            'department',
            'position',
            'description',
            'creTime',
            'creUser.username',
            'updTime',
            'updUser.username',
        ],
    ] )
    ?>

</div>
