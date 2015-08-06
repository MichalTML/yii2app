<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OClientContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prospect Clients Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Client Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Prospect Client Manager', 'url' => ['site/other-clients']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="oclient-contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Contact', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'client.name',
            'firstName',
            'lastName',
            [
                'attribute' => 'gender.genderName',
                'value' => 'gender.genderName',
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(\frontend\models\Gender::find()->asArray()->all(), 'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ']),
],
            'phone',
            // 'fax',
            'email:email',
            'department',
            'position',
            'creUser.username',
            'creTime',
            // 'creUserId',
            // 'updTime',
            // 'updUserId',
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
