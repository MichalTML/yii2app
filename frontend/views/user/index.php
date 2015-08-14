<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\User;
use frontend\models\Status;
use frontend\models\search\UserSearch;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Administration';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="user-index">
    
<?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//    'rowOptions' => function ($model){
//                if($model->status_id == 0) {
//                    return ['class' => 'danger'];
//                } else {
//                    return ['class' => 'success'];
//                }
//    },
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            [
                'label' => 'User Name',
                'attribute' => 'username',
                'value' => 'username',
                'width' => '100px',
                'hAlign' => 'left'
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'format' => 'email',
                'value' => 'email',
                'width' => '120px',
                'hAlign' => 'left'
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status_id',
                'filter' => Html::activeDropDownList( $searchModel, 'status.status_name', ArrayHelper::map( Status::find()->asArray()->all(), 'status_name', 'status_name' ), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'format' => 'raw',
                'value' => 'status.status_name',
                'editableOptions' => [
                    'header' => '.',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => User::getStatusList(),
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-success' ],
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'role_id',
                'filter' => Html::activeDropDownList( $searchModel, 'role.role_name', User::getSearchRoleList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'value' => 'role.role_name',
                'editableOptions' => [
                    'header' => '.',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => User::getEditableRoleList(),
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-info' ]
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
                'pageSummary' => false
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column)
                {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column)
                {
                    $searchModel = new UserSearch();
                    $searchModel->id = $model->id;
                    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
                    
                    return Yii::$app->controller->renderPartial( '_detailView', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'model' => $model,
                    ] );
                },
                        'headerOptions' => ['class' => 'kartik-sheet-style' ],
                        'expandOneOnly' => true,
            ],
                ]
] );
            ?>

</div>
