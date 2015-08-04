<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = $model->getClientName();
$this->params[ 'breadcrumbs' ][] = ['label' => 'Clients Manager', 'url' => ['site/clients' ] ];
$this->params[ 'breadcrumbs' ][] = ['label' => 'Client Contacts', 'url' => ['index' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="client-contacts-view">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <p>
        <?php
        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) > 30 )
        {
            echo Html::a( 'Delete', ['delete', 'id' => $model->clientId ], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ] );
        } else
        {

            echo Html::a( 'Update', ['update', 'id' => $model->clientId ], ['class' => 'btn btn-primary' ] );
        }
        ?>
    </p>

    <?=
    DetailView::widget( [
        'model' => $model,
        'attributes' => [
            'clientName',
            'firstName',
            'lastName',
            'genderName',
            'phone',
            'fax',
            'email:email',
            'department',
            'position',
            'creTime',
            'creUserName',
            'updTime',
            'updUserName',
            'description',
        ],
    ] )
    ?>

</div>
