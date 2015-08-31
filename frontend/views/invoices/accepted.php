<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accepted Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Not Accepted Invoices', 'url' => ['invoices/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoices-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('View Not Accepted Invoices', ['index'], ['class' => 'btn btn-success']) ?>
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
            'acceptedBy',
            // 'creTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
