<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accepted Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Not Accepted Invoices', 'url' => ['invoices/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoices-accepted">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('View Not Accepted Invoices', ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
         'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'headerRowOptions' => ['class' => 'header'],
        'emptyCell' => '',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; line-height: 2.5em;'],
            ],
            [
                'label' => 'File Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                
            ],
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'supplierId',
                'label' => 'Supplier',
                'headerOptions' => ['style' => 'text-align: center;'],
//              'filter' => Html::activeDropDownList( $searchModel, 'status.status_name', ArrayHelper::map( Status::find()->asArray()->all(), 'status_name', 'status_name' ), ['class' => 'form-control', 'prompt' => ' ' ] ),
                //'format' => 'raw',
                'value' => 'supplierId',
                 'contentOptions' => ['style' => 'text-align: center;'],
                'editableOptions' => [
                    'header' => ' ',
                    'inputType' => Editable::INPUT_TEXT,
//                    'data' => 'supplierId',
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-blue' ],
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'connection',
                'label' => 'Connected to',
                'headerOptions' => ['style' => 'text-align: center;'],
//              'filter' => Html::activeDropDownList( $searchModel, 'status.status_name', ArrayHelper::map( Status::find()->asArray()->all(), 'status_name', 'status_name' ), ['class' => 'form-control', 'prompt' => ' ' ] ),
                //'format' => 'raw',
                'value' => 'connection',
                'contentOptions' => ['style' => 'text-align: center;'],
                'editableOptions' => [
                    'header' => ' ',
                    'inputType' => Editable::INPUT_TEXT,
//                    'data' => 'supplierId',
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-blue' ],
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
            ],
            
             
            [
                'label' => 'Accepted by',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'user.username',
                'value' => 'user.username',
                
            ],
            [
                'label' => 'Accepted at',
                'contentOptions' => ['style' => 'text-align: center; width: 100px;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'acceptedAt',
                'value' => 'acceptedAt',
                
            ],
             [
                'label' => 'Accepted at',
                'contentOptions' => ['style' => 'text-align: center; width: 100px;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'acceptedAt',
                'value' => 'acceptedAt',
                
            ],
            [
                'label' => 'Created at',
                'contentOptions' => ['style' => 'text-align: center; width: 100px;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creTime',
                'value' => 'creTime',
                
            ],

            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 20px; width: 20px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; line-height: 2em;' ],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model)
                                    {
                                        return Html::a( '<div class="postImage">
                                                <span class="fa fa-file-pdf-o"></span>
                                                <span class="title">'.
                                                '<img src="http://4.bp.blogspot.com/-ehPN-aWI8O8/T-G60drsdRI/AAAAAAAAJJI/2thofc5S8IU/s1600/pdf.png"></img></span>'.
                                                '</div>', $url, 
                                                       [ 
                                                        'target' => '_blank',
                                                        'data-method' => 'post',
                                                        'title' => Yii::t( 'app', 'view' ),
                                                        'data' => [
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        },
//                                        return Html::button( '<a href=""><i class="fa fa-file-pdf-o"></i></a>', ['value' => $url, 'class' => 'pdff-button', 'id' => 'pdffButton']);
//                                    },
//                                            'delete' => function($url, $model)
//                                    {
//                                        if ( $model->isAccepted == 1 )
//                                        {
//                                            return '<span class="glyphicon glyphicon-trash"></span>';
//                                        } else
//                                        {
//                                            return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [ 
//                                                        'data-method' => 'post',
//                                                        'title' => Yii::t( 'app', 'delete' ),
//                                                        'data' => [
//                                                            'confirm' => 'You are about to delete file: ' . $model->name . ' ,are you sure you want to                                                proceed?',
//                                                            'method' => 'post',
//                                                        ],
//                                                    ] );
//                                        }
//                                    },
                                            'accept' => function($url, $model)
                                    {
                                           return Html::a( '<span class="fa fa-thumbs-o-up"></span>', $url, [ 'data-method' => 'post', 'title' => Yii::t( 'app', 'accept' ) ] );
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model)
                                {
//                                    if ( $action === 'delete' )
//                                    {
//                                        $url = Url::toRoute( ['invoices/delete', 'id' => $model->id ] );
//                                        return $url;
//                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['invoices/view', 'path' => $model->path, 'name' => $model->name ] );
                                        return $url;
                                    }
                                   
                                    
                                }
                                    ],
                                ],
                            ] ); ?>

</div>
