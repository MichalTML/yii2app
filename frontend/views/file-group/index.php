<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\FileGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create File Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fileId',
            'groupId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
