<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectAssembliesFilesNotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Assemblies Files Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assemblies-files-notes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Assemblies Files Notes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fileId',
            'note',
            'typeId',
            'creUserId',
            // 'creTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
