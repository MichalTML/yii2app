<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OClientDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Promote Client';
$this->params['breadcrumbs'][] = ['label' => 'Project List', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create project', 'url' => ['project/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oclient-data-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'status.statusName',
            'name',
            //'abr',
            // 'adress',
            // 'city',
            // 'postal',
            'phone',
            // 'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            // 'www',
            // 'description',
            'creTime',
            'creUser.username',
            // 'updTime',
            // 'updUserId',

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Promote',
                'template' => '<div class="action">{promote}</div>',
                'buttons' => [
                    'promote' => function ( $url, $model) {
                     return Html::a('<i class="fa fa-plus"></i>', $url.='&id='.$model->id,
                             [
                                 'title' => Yii::t('app', 'promote'),
                             ]);
                    }
                ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'promote') {
                        return Url::to(['o-client-data/promotion']);
                    }
                        }
                
                ],
        ],
    ]); ?>

</div>
