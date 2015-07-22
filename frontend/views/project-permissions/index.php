<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectPermissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-permissions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Permissions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'projectId',
            'userId',
            'create',
            'edit',
            // 'view',
            // 'delete',
            // 'creTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
