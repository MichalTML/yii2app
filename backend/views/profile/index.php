<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">
    
     <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <p>
        <?= Html::a('Create Profile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php echo Collapse::widget([
        
        'items' => [
            [
                'label' => 'Search',
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
            ]
    ]);
    ?>  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            ['attribute' => 'profileIdLink', 'format' => 'raw'],
            ['attribute' => 'userLink', 'format' => 'raw'],
            'first_name',
            'last_name',
            'birthdate',
            'genderName',
            ['class' => 'yii\grid\ActionColumn'],

//            'id',
//            'user_id',
//            'first_name:ntext',
//            'last_name:ntext',
//            'birthdate',
            // 'gender_id',
            // 'created_at',
            // 'updated_at',
            ],
    ]); ?>

</div>
