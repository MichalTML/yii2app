<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\models\Role;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserAttendanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Attendances';
$this->params['breadcrumbs'][] = ['label' => 'Other Tools', 'url' => ['site/options']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-attendance-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
               'label' => 'First Name',
               'attribute' => 'firstName',
               'value' => 'firstName',
            ],
            [
                'label' => 'Last Name',
                'attribute' => 'lastName',
                'value' => 'lastName',
            ],
            [
                'label' => 'Email',
                'attribute' => 'user.email',
                'format' => 'email',
                'value' => 'user.email'
            ],
            [
                'label' => 'Position',
                'attribute' => 'role.role_name',
                'filter' => Html::activeDropDownList($searchModel, 'role.role_name', ArrayHelper::map(Role::find()->asArray()->all(),
                'role_name','role_name'),['class'=>'form-control', 'prompt' => ' ', 'style' => 'width: 100px;']),
                'value' => 'role.role_name',
            ],

             ['class' => 'yii\grid\ActionColumn',
                        'header' => '',
                        'headerOptions' => ['style' => 'border-bottom-color: transparent;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'template' => '{attendance}',
                        'buttons' => [
                                    'attendance' => function($url, $model)
                            {
                                return Html::a( '<span class="fa fa-calendar"></span>', $url, [
                                            'data-method' => 'post',
                                            'title' => Yii::t( 'app', 'view' ),
                                        ] );
                            }
                                ],
                                'urlCreator' => function ($action, $model, $key, $index)
                        {
                            if ( $action === 'attendance' )
                            {
                                $url = Url::toRoute( ['user-attendance/attendances', 'id' => $model->userId ] );
                                return $url;
                            }
                        }
                            ],
        ],
    ]); ?>

</div>
