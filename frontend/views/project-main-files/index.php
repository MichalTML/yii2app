<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectMainFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Main Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-main-files-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Main Files', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'projectId',
            'ext',
            'size',
            'createdAt',
            // 'updatedAt',
            // 'path',
            // 'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
