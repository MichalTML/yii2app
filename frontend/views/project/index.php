<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects list';
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
            ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => 'color: black;'],
                ],
            

            

            //'id',
            'projectName',            
            'deadline',
            'projectStatus',
            'clientData.name',
            // 'endDate',
            'creUserId',
            //'updUserId',
            'creTime',
            'updTime',         
            
            ['class' => 'yii\grid\ActionColumn',
             'header' => 'Action',
             'headerOptions' => ['style' => 'min-width: 100px; text-align: center;'],
             'template' => '{update} | {delete} | {view}',
             
                
                
                
                
                ],
            
        ],
    ]); ?>

</div>
