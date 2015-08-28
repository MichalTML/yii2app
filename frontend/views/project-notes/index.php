<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectNotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-notes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Notes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'projectId',
            'note',
            'creUserId',
            'creTime',
            // 'updTime',
            // 'updUserId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
