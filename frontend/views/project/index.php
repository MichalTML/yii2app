<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\ProjectData;

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
        <?= Html::a('Create new project', ['create'], ['class' => 'btn btn-default login']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
        'filterModel' => $searchModel,       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => 'color: black;'],
                ],
            'sygnature',
            'projectName',            
            'deadline',
            'projectStatus0.statusName',
            'ClientName', 
            'projectPermissionsUsers',
            'creUserName',
            'creTime',            
            //'updUserName',
            //'updTime',
           
            ['class' => 'yii\grid\ActionColumn',
             'header' => 'Action',
             'headerOptions' => ['style' => 'min-width: 100px; text-align: center;'],
             'template' => '{update} | {delete} | {view}',
             
                
                
                
                
                ],
            
        ],
    ]); ?>
    
    

</div>
