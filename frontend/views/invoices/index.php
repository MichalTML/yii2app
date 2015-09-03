<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Not Accepted Invoices';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Accepted Invoices', 'url' => ['invoices/accept']];
?>
<div class="invoices-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('View Accepted Invoices', ['accepted'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => false,
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
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'signedBy',
                'label' => 'Signed By',
                'headerOptions' => ['style' => 'text-align: center;'],
//              'filter' => Html::activeDropDownList( $searchModel, 'status.status_name', ArrayHelper::map( Status::find()->asArray()->all(), 'status_name', 'status_name' ), ['class' => 'form-control', 'prompt' => ' ' ] ),
                //'format' => 'raw',
                'value' => 'signedBy',
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
                'label' => 'Created at',
                'contentOptions' => ['style' => 'text-align: center; line-height: 2.5em;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creTime',
                'value' => 'creTime',
                
            ],
            
              ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 70px; width: 70px;text-align: center; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; line-height: 2em;' ],
                                'template' => '{view} {accept} {delete}',
                                'buttons' => [
                                    'accept' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-th-list"></i></a>', ['value' => $url, 'class' => 'accept-button', 'id' => 'acceptButton'] );
                                    },
                                    'view' => function ($url, $model)
                                    {
                                        $imageName = $model->name.'.jpg';
                                        return Html::a( 
                                                '<div class="postImage">
                                                <span class="fa fa-file-pdf-o"></span>
                                                <span class="title">'.
                                                Html::img('@web/assets/'.$imageName).'</span>'.
                                                '</div>',$url, 
                                                       [ 
                                                        'target' => '_blank',
                                                        'data-method' => 'post',
                                                        'title' => ''/*Yii::t( 'app', 'view' )*/,
                                                        'data' => [
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        },
//                                        return Html::button( '<a href=""><i class="fa fa-file-pdf-o"></i></a>', ['value' => $url, 'class' => 'pdff-button', 'id' => 'pdffButton']);
//                                    },
                                            'delete' => function($url, $model)
                                    {
                                        if ( $model->isAccepted == 1 )
                                        {
                                            return '<span class="glyphicon glyphicon-trash"></span>';
                                        } else
                                        {
                                            return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [ 
                                                        'data-method' => 'post',
                                                        'title' => Yii::t( 'app', 'delete' ),
                                                        'data' => [
                                                            'confirm' => 'You are about to delete file: ' . $model->name . ' ,are you sure you want to proceed?',
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        }
                                    },
                                            'accept' => function($url, $model)
                                    {
                                           return Html::a( '<span class="fa fa-thumbs-o-up"></span>', $url, [ 'data-method' => 'post', 'title' => Yii::t( 'app', 'accept' ),
                                               'data' => [
                                                            'confirm' => 'You are about to accept file: ' . $model->name . ' ,are you sure you want to proceed?',
                                                            'method' => 'post',
                                                        ],] );
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model)
                                {
                                    if ( $action === 'delete' )
                                    {
                                        $url = Url::toRoute( ['invoices/delete', 'id' => $model->id ] );
                                        return $url;
                                    }
                                    if ( $action === 'accept' )
                                    {
                                        $url = Url::toRoute( ['invoices/accepted', 'id' => $model->id ] );
                                        return $url;

                                    }
                                    if ( $action === 'view' )
                                    {
                                        $url = Url::toRoute( ['invoices/view', 'path' => $model->path, 'name' => $model->name ] );
                                        return $url;
                                    }
                                   
                                    
                                }
                                    ],
                                ],
                            ] ); ?>
    
    <?php Pjax::end(); ?>


</div>
