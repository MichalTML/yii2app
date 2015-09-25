<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PermissionHelpers;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use frontend\models\ClientKrsFiles;

$this->title = 'Clients List';
$this->params[ 'breadcrumbs' ][] = ['label' => 'Clients Manager', 'url' => ['site/clients' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="client-data-index">


    <?php Pjax::begin( ['id' => 'pjax-data' ] ); ?>

    <p>
        <?= Html::a( 'New Client', ['create' ], ['class' => 'btn btn-success' ] ) ?>
    </p>
    <?php
    echo GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'layout' => '{items} {pager}',
        'headerRowOptions' => ['style' => 'font-size: 10px' ],
        'rowOptions' => ['style' => 'font-size: 10px' ],
        'columns' => [
            [
                'label' => 'Client Number',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'clientNumber',
                'value' => 'clientNumber',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Name',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'City',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'city',
                'value' => 'city',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Phone',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'phone',
                'value' => 'phone',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Email',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'email',
                'format' => 'email',
                'value' => 'email',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'www',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'www',
                'format' => 'raw',
                'value' => function($model){
                                return '<a target="_blank" href="http://'.$model->www.'">'.$model->www.'</a>';
                },
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Nip',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'nip',
                'value' => 'nip',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Krs',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'krs',
                'value' => 'krs',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Regon',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'regon',
                'value' => 'regon',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Created At',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'creTime',
                'value' => 'creTime',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            [
                'label' => 'Created By',
                'headerOptions' => ['style' => 'text-align: center;' ],
                'attribute' => 'creUser.username',
                'value' => 'creUser.username',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header' => '',
                'headerOptions' => ['style' => 'min-width: 90px;text-align: center; border-bottom-color: transparent;' ],
                'contentOptions' => ['style' => 'text-align:center; line-height: 3em;' ],
                'template' => '{viewkrs} {uploadkrs} {view} {edit} {delete}',
                'buttons' => [
                    'viewkrs' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            if ( $model->krsFile == 1 )
                            {
                                $krsFile = new ClientKrsFiles;
                                $result = $krsFile->find()->where( ['clientId' => $model->id ] )->one();
                                $imagePath = '';
                                if ( !empty( $result ) )
                                {
                                    if ( file_exists( 'krs-pdf/' . $result->name ) )
                                    {
                                        $imgName = explode( '.', $result->name );
                                        $imagePath = 'krs-pdf/' . $imgName[ 0 ] . '.jpg';
                                    }
                                }
                                return Html::a(
                                                '<div class="postImage"  style="float:left">
                                                <span class="fa fa-file-pdf-o"></span>
                                                <span class="title">' .
                                                Html::img( $imagePath ) . '</span>' .
                                                '</div>', $url, [
                                                'target' => '_blank',
                                                'data-method' => 'post',
                                                'title' => 'view krs file',
                                                'data' => [
                                                    'method' => 'post',
                                                ],
                                        ] );
                            } else
                            {
                                return '<div class="postImage"  style="float:left"><i class="fa fa-file-o" ></i></div>';
                            }
                        } else
                        {
                                return '<div class="postImage"  style="float:left"><i class="fa fa-file-o" ></i></div>';
                        }
                    },
                            'uploadkrs' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            return Html::button( '<a href=""><i class="fa fa-upload"></i></a>', 
                            ['value' => $url, 'style' => 'float:left; padding-left: 5px; padding-right: 5px',
                             'class' => 'ukrs-button', 'id' => 'krs-upload', 'title' => 'upload krs file' ] );
                        } else
                        {
                            return '<div class="postImage"  style="float:left; padding-left: 5px; '
                            . 'padding-right: 5px"><i class="fa fa-upload"></i></div>';
                        }
                    },
                            'delete' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'data-method' => 'post',
                                        'style' => 'float:left; padding-left: 5px',
                                        'title' => Yii::t( 'app', 'delete' ),
                                        'data' => [
                                            'confirm' => 'You are about to delete: ' . $model->name . 
                                            ', are you sure you want to proceed?',
                                            'method' => 'post',
                                        ],
                                    ] );
                        } else
                        {
                            return '<i class="glyphicon glyphicon-trash"></i>';
                        }
                    },
                            'edit' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, 
                            [ 'data-method' => 'post', 'style' => 'float:left; padding-left: 5px', 
                                'title' => Yii::t( 'app', 'edit' ) ] );
                        } else
                        {
                            return '<i class="glyphicon glyphicon-pencil"></i>';
                        }
                    },
                            'view' => function($url, $model)
                    {
                        return Html::button( '<a href="#"><i class="glyphicon glyphicon-eye-open"></i></a>', 
                        ['value' => $url, 'class' => 'view-button','style' => 'float:left; padding-left: 5px', 
                            'id' => 'view-button', 'title' => 'view' ] );
                    }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index)
                {
                    if ( $action === 'delete' )
                    {
                        $url = Url::toRoute( ['client/delete', 'id' => $model->id ] );
                        return $url;
                    }
                    if ( $action === 'edit' )
                    {
                        $url = Url::toRoute( ['client/update', 'id' => $model->id ] );
                        return $url;
                    }
                    if ( $action === 'view' )
                    {
                        $url = Url::toRoute( ['client/view', 'id' => $model->id ] );
                        return $url;
                    }
                    if ( $action === 'viewkrs' )
                    {
                        $krsFileData = new ClientKrsFiles;
                        $krsData = $krsFileData->find()->where( ['clientId' => $model->id ] )->one();
                        if ( $krsData )
                        {
                            $url = Url::toRoute( ['client/viewkrs', 'path' => $krsData->path, 'name' => $krsData->name ] );
                        } else
                        {
                            $url = '';
                        }
                        return $url;
                    }
                    if ( $action === 'uploadkrs' )
                    {
                        $url = Url::toRoute( ['client/uploadkrs', 'id' => $model->id ] );
                        return $url;
                    }
                }
                    ],
                ],
            ] );
            ?>

        </div>

        <?php
        Modal::begin( [
            'id' => 'krs-modal',
            'headerOptions' => ['style' => 'display:none' ],
        ] );
        echo "<div id='modalContent'></div>";
        Modal::end();


        $this->registerJs( "
$(function(){
    // get the click event of the Note button
    $('.vkrs-button').click(function(){
        $('#krs-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(function(){
    // get the click event of the Note button
    $('.view-button').click(function(){
        $('#view-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(function(){
    // get the click event of the Note button
    $('.ukrs-button').click(function(){
        $('#krs-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(document).on('pjax:timeout', function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});
" );

        Modal::begin( [
            'id' => 'view-modal',
            'header' => '<h4 class="modal-title">Client Details</h4>',
        ] );
        echo "<div id='modalContent'></div>";

        Modal::end();


        Pjax::end();
        