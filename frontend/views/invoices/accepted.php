<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;
use frontend\models\Invoices;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

$this->title = 'Accepted Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Not Accepted Invoices', 'url' => ['invoices/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoices-accepted">

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
        'headerRowOptions' => ['class' => 'header','style' => 'font-size: 11px'],
        'rowOptions' => ['class' => 'lighted-row', 'style' => 'font-size: 11px'],
        'emptyCell' => '',
        'summary' => '',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center; font-weight: bold; vertical-align:middle;'],
            ],
            [
                'label' => 'File Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'name',
                'value' => 'name',
                'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;'],
                
            ],
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'supplierId',
                'label' => 'Supplier',
                'headerOptions' => ['style' => 'text-align: center;'],
                'value' => 'supplierId',
                 'contentOptions' => ['style' => 'text-align: center;vertical-align:middle;'],
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
                'contentOptions' => ['style' => 'text-align: center;vertical-align:middle;'],
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
                'label' => 'Accepted by',
                'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;'],
                'headerOptions' => ['style' => 'text-align: center; '],
                'filter' => Html::activeDropDownList( $searchModel, 'acceptedBy', 
                        Invoices::getAcceptedBy(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'attribute' => 'acceptedBy',
                'value' => 'user.username',
                
            ],
             [
                'label' => 'Scanned By',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'scannedBy',
                'value' => 'scannedBy',
                 'filter' => Html::activeDropDownList( $searchModel, 'scannedBy', 
                         Invoices::getScannedBy(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'contentOptions' => ['style' => 'text-align: center; width: 100px; vertical-align:middle; white-space: nowrap;'],
                
            ],
            [
                'attribute' => 'signedBy',
                'label' => 'Signed By',
                'filter' => Html::activeDropDownList( $searchModel, 'signedBy', 
                        Invoices::getEmployesList(), ['class' => 'form-control', 'prompt' => ' ' ] ),
                'contentOptions' => ['style' => 'vertical-align:middle; text-align: center; width: 150px; white-space: nowrap;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'value' => 'employes.name',
                
            ],
             [
                'label' => 'Accepted At',
                'contentOptions' => ['style' => 'text-align: center; width: 100px; vertical-align:middle'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'acceptedAt',
                'value' => 'acceptedAt',
                
            ],
            [
                'label' => 'Created At',
                'contentOptions' => ['style' => 'text-align: center; width: 100px; vertical-align:middle;'],
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creTime',
                'value' => 'creTime',
                
            ],

            ['class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'headerOptions' => ['style' => 'text-align: center; ' ],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle' ],
                                'template' => '{view}',
                                'buttons' => [
                                      'view' => function ($url, $model)
                                    {
                                        
                                        return Html::a('<span class="fa fa-file-pdf-o"></span>', $url,                                        
                                                       [ 
                                                        'target' => '_blank',
                                                        'class' => $model->id,
                                                        'imagePath' => '/assets/' . $model->name . '.jpg',
                                                        'data-method' => 'post',
                                                        'title' => 'download PDF'/*Yii::t( 'app', 'view' )*/,
                                                        'data' => [
                                                            'method' => 'post',
                                                        ],
                                                    ] );
                                        },                                  
                                            'accept' => function($url, $model)
                                    {
                                           return Html::a( '<span class="fa fa-thumbs-o-up"></span>', $url, 
                                                  [ 'data-method' => 'post', 'title' => Yii::t( 'app', 'accept' ) ] );
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

<?php
Modal::begin( [
            'id' => 'pdf-modal',
            'closeButton' => false,
            'headerOptions' => ['style' => 'display:none' ],
            'header' => '<h4 class="modal-title">Project Details</h4>',
            //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
            ] );
         echo "<div id='modalContent'></div>";
Modal::end();
