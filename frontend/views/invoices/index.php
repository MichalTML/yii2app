<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;
use common\models\PermissionHelpers;
use frontend\models\Invoices;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

$this->title = 'Not Accepted Invoices';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Accepted Invoices', 'url' => ['invoices/accept']];

?>
<div class="invoices-index">

    <?= GridView::widget([        
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,        
        'pjaxSettings' =>
            [
                'neverTimeout'=>true,
                'options'=>['id'=>'pjax-data'],
                'loadingCssClass' => false,
            ], 
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => false,
        'headerRowOptions' => ['class' => 'header' , 'style' => 'font-size: 11px;'],
        'rowOptions' => function($model){
                            if($model->flag == 0){
                                return ['class' => 'lighted-row', 'style' => 'font-size: 11px;'];
                            } else {
                                return ['class' => 'lighted-row', 'style' => 'font-size: 11px; background-color:#E599A3;'];
                            }
        },
        'summary' => '',
        'emptyCell' => '',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; vertical-align: middle;'],
            ],
            [
                'label' => 'File Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'supplierId',
                'label' => 'Supplier',
                'headerOptions' => ['style' => 'text-align: center; '],
                'value' => 'supplierId',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'editableOptions' => [
                    'header' => ' ',
                    'inputType' => Editable::INPUT_TEXT,
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
                'format' => 'raw',
                'value' => function($model){
                $data = Invoices::getCategoryList();
                // Using a select2 widget inside a modal dialog
                Modal::begin([
                    'options' => [
                        'id' => 'kartik-modal',
                        'tabindex' => false // important for Select2 to work properly
                    ],
                    'header' => '<h4 style="margin:0; padding:0">Edit Connected to</h4>',
                ]);
                echo Select2::widget([
                    'name' => 'connected',
                    'attribute' => 'state_10',
                    'data' => $data,
                    'size' => Select2::MEDIUM,
                    'options' => ['placeholder' => '', 'multiple' => true, 'id' => 'connected', 'hideSearch' => false ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); 
                echo Html::button( 'Accept', ['class' => 'btn btn-success change-button', 
                    'id' => 'change-button', 'style' => 'margin-top: 10px;'] );
                Modal::end();
                
                $this->registerJs("
                        $('.connection-button').click(function(){
                            var tags;
                            var url = $(this).data('url');
                            var id = $(this).data('id');
                            $('#connected').change(function(e){
                                    tags = ($(this).val());
                                });
                            $('#kartik-modal').modal('show');
                            $('#change-button').click(function(){
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    data: {data:tags, id:id},
                                    success: function (msg) {
                                        $('#kartik-modal').modal('hide');
                                    }
                                })
                            });
                        });");

       
                    $buttonInfo = $model->connection;
                    if(empty($buttonInfo)){
                        $buttonInfo = 'not set';
                    
                        return Html::button( $buttonInfo, ['class' => 'connection-button text-blue', 
                        'id' => 'connection-button', 'data-id' => $model->id, 
                        'data-url' => Url::toRoute( ['invoices/tagme'] ), 'style' => 'color: red; border-bottom: 1px solid red;' ] );
                    } else {
                        return Html::button( $buttonInfo, ['class' => 'connection-button text-blue', 
                        'id' => 'connection-button', 'data-id' => $model->id, 
                        'data-url' => Url::toRoute( ['invoices/tagme'] ), 'style' => 'border-bottom: 1px solid #87cd00;' ] );
                    }
                },                              
                'contentOptions' => ['style' => 'text-align: center; '],
                'editableOptions' => [
                    'header' => ' ',
                    'inputType' => Editable::INPUT_TEXT,
                    'options' => ['class' => 'form-control' ],
                    'editableValueOptions' => ['class' => 'text-blue', 'style' => 'margin:0' ],
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
                'filter' => Html::activeDropDownList( $searchModel, 'signedBy', 
                            Invoices::getEmployesList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'value' => 'employes.name',
                 'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                 'editableOptions' => [
                    'header' => '',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data'=> Invoices::getEmployesList(),
                    'options' => ['class' => 'form-control', 'style' => 'width: 200px; text-align: center;'],
                    'editableValueOptions' => ['class' => 'text-blue'],
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '120px',
            ],
             [
                'label' => 'Scanned By',
                'headerOptions' => ['style' => 'text-align: center;'],
                'filter' => Html::activeDropDownList( $searchModel, 'scannedBy', 
                            Invoices::getScannedBy(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'attribute' => 'scannedBy',
                'value' => 'scannedBy',
                'contentOptions' => ['style' => 'text-align: center; width: 100px; vertical-align: middle; white-space: nowrap;'],
                
            ],
             [
                'label' => 'Created At',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creTime',
                'value' => 'creTime',
                
            ],
            
              ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'min-width: 90px; width: 90px;'
                                    . 'text-align: right; border-bottom-color: transparent;' ],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align: middle' ],
                                'template' => '{view} {accept} {flag} | {delete}',
                                'buttons' => [
                                    'accept' => function ($url, $model)
                                    {
                                        return Html::button( '<a href=""><i class="fa fa-th-list "></i></a>', 
                                              ['value' => $url, 'class' => 'accept-button', 'id' => 'acceptButton'] );
                                    },
                                    'view' => function ($url, $model)
                                    {
                                        
                                        return Html::a('<span class="fa fa-file-pdf-o"></span>', $url,                                        
                                                       [ 
                                                        'target' => '_blank',
                                                        'class' => $model->id,
                                                        'imagePath' => '/assets/' . $model->name . '.jpg',
                                                        'data-method' => 'post',
                                                        'title' => 'download PDF',
                                                        'data' => [
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        },
                                            'delete' => function($url, $model)
                                    {
                                            $name = 'nope';
                                            if(Yii::$app->user->identity->id == 38){
                                                $name = "Beata Koprowska";
                                                
                                            } 
                                            if(Yii::$app->user->identity->id == 43){
                                                $name = "Patrycja Kubicka";
                                            } 
                                            if(Yii::$app->user->identity->id == 37){
                                                $name = "Danuta Fiałek";
                                            } 
                                            
                                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) 
                                        >= 50 || $name == $model->scannedBy )
                                        {
                                            return Html::a( '<span class="glyphicon glyphicon-trash" style="margin-left:10px;"></span>', $url, [ 
                                                        'data-method' => 'post',
                                                        'title' => Yii::t( 'app', 'delete' ),
                                                        'data' => [
                                                            'confirm' => 'You are about to delete file: ' . 
                                                            $model->name . ' ,are you sure you want to proceed?',
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        } else {
                                            return '<span class="glyphicon glyphicon-trash"></span>';
                                            
                                        }
                                    },
                                            'accept' => function($url, $model)
                                    {
                                           if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 50 ) {
                                           return Html::a( '<span class="fa fa-thumbs-o-up"></span>', 
                                                   $url, [ 'data-method' => 'post', 'title' => Yii::t( 'app', 'accept' ),
                                               'data' => [
                                                            'confirm' => 'You are about to accept file: ' . 
                                                   $model->name . ' ,are you sure you want to proceed?',
                                                            'method' => 'post',
                                                        ],] );
                                           } else {
                                               return '<span class="fa fa-thumbs-o-up"></span>';
                                           }
                                    },
                                            'flag' => function($url, $model)
                                    {
                                        $this->registerJs("
                                        $('.flag-button').click(function(){
                                            var url = $(this).data('url');
                                            var id = $(this).data('id');
                                            var action = $(this).data('action');
                                            $.ajax({
                                                url: url,
                                                type: 'post',
                                                data: {action:action, id:id},
                                                success: function (msg) {
                                                    $.pjax.reload('#pjax-data');
                                                }
                                            })
                                        });");
                                           if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 50 ) {
                                               if($model->flag == 0){
                                           return Html::button( '<a href=""><i class="fa fa-flag"></i></a>', 
                                           ['value' => $url, 'class' => 'flag-button', 'data-action' => 'flag', 'data-id' => $model->id, 
                                            'data-url' => $url, 'title' => 'flag' ] );                                               
                                           } else {
                                           return Html::button( '<a href=""><i class="fa fa-flag-o"></i></a>', 
                                           ['value' => $url, 'class' => 'flag-button', 'data-action' => 'unflag', 'data-id' => $model->id, 
                                            'data-url' => $url, 'title' => 'flag' ] );   
                                           }
                                           }
                                           return '<span class="fa fa-flag-o"></span>';
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model)
                                {
                                         //custom JS for gridView AjaxUse
                                        
                                        
                                  $this->registerJs("
                                        $('#kartik-modal').on('hidden.bs.modal', function () {
                                                             $.pjax.reload('#pjax-data');
                                                        });        
                                                        
                                        $('.lighted-row').each(function(){  
                                        var rowId;
                                        var imagePath;
                                        $(this).hover(  
                                          function() {
                                                rowId = $(this).attr('data-key');                                                 
                                                $(this).addClass('light-on');
                                          }, function() {
                                                $(this).removeClass('light-on');
                                          }
                                        );
                                        $('td:eq(1)', this).css('cursor', 'pointer');
                                        $('td:eq(1)', this).click(function(){
                                            
                                                imagePath = $('.' + rowId).attr('imagePath');
                                                    if(typeof imagePath != 'undefined'){
                                                        $('#pdf-modal').modal('show');
                                                        $('#pdf-modal .modal-content').css('background-image', 'url(' + imagePath + ')');
                                                    }
                                        });

                                    });");
                                  
                                    if ( $action === 'flag' )
                                    {
                                        $url = Url::toRoute( ['invoices/flag', 'id' => $model->id ] );
                                        return $url;
                                    }
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
<?php
    Modal::begin( [
                'id' => 'pdf-modal',
                'closeButton' => false,
                'headerOptions' => ['style' => 'display:none' ],
                'header' => '<h4 class="modal-title"></h4>',
                ] );
             echo "<div id='modalContent'></div>";
    Modal::end();
?>
    
</div>

