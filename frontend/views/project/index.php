<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project index';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create new project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'projectId',
            'projectName',            
            'deadline',
            'constructorId',
            'projectStatus',
            'clientData.name',
            // 'endDate',
            'user.firstlastName',
            //'updUserId',
            'creDate',
            'updDate',         
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
