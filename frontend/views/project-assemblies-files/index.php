<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectAssembliesFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Assemblies Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-files-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Assemblies Files', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'projectId',
            'assemblieId',
            'typeId',
            'sygnature',
            // 'name',
            // 'path',
            // 'size',
            // 'ext',
            // 'flag',
            // 'thickness',
            // 'quanity',
            // 'material',
            // 'quanityDone',
            // 'status',
            // 'priority',
            // 'feedback',
            // 'createdAt',
            // 'updatedAt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
