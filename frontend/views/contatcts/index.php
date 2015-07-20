<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clientId',
            'firstlastName',
            'gender',
            'phone',
            'fax',
            // 'email:email',
            // 'department',
            // 'position',
            // 'creTime',
            // 'creUser',
            // 'updTime',
            // 'updUser',
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
