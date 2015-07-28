<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('Create Client Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clientName',
            'firstName',
            'lastName',
            'genderName',
            'phone',
            // 'fax',
             'email:email',
            'department',
            'position',
            'creUserName',
            'creTime',
            //'creUserId',
            // 'updTime',
            // 'updUserId',
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);?>

</div>
