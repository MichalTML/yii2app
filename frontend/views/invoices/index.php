<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Not Accepted Invoices';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Accepted Invoices', 'url' => ['invoices/accepted']];
?>
<div class="invoices-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('View Accepted Invoices', ['accepted'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'supplierId',
            'connection',
            'isAccepted',
            // 'ext',
            // 'path',
            // 'acceptedBy',
            // 'creTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
