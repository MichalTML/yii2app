<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectFileDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project File Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-file-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project File Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'projectId',
            'path',
            'root',
            'files',
            'createdAt',
            // 'assembliesMainFiles',
            // 'projectMainFiles',
            // 'assembliesFiles',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
