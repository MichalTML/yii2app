<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectAssembliesDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Assemblies Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Assemblies Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'projectId',
            'name',
            'path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
