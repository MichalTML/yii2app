<?php

use kartik\grid\GridView;
use frontend\models\ProjectFileData;
use yii\widgets\Pjax;

?>

<div class="project-data-list">
<?php pjax::begin(['enablePushState' => false]) ?>
    <?=
    GridView::widget( [
        'dataProvider' => $projectData,
        'filterModel' => $projectSearch,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'pjax'=>true,
        'summaryOptions' => ['style' => 'display:none'],
        'pjaxSettings'=>[
            'loadingCssClass'=>false,
            'neverTimeout'=>true,
            'enablePushState'=>false,
        ],
        'filterRowOptions' => ['style' => 'display:none'],
        'headerRowOptions' => ['style' => 'font-size: 12px'],
        'rowOptions' => function ($model)
                        {
                        $filesSearch = ProjectFileData::find()->where(['projectId' => $model->sygnature])->one();
                            if(isset($filesSearch->projectId)){                                            
                                return ["style" => "background-color:#e6e6e6; font-size:12px"];                                
                            } else {
                                return ["style" => "border-color:white; font-size:12px"];
                                    }},
                'columns' => [
                    [
                        'label' => 'Project Nr',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'sygnature',
                        'value' => 'sygnature',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                    ],
                    [
                        'label' => 'Project Name',
                        'attribute' => 'projectName',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'value' => 'projectName',
                        'contentOptions' => ['style' => 'text-align: left; vertical-align: middle; white-space: nowrap;' ]
                    ],                    
                    [
                        'label' => 'Status',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'projectStatus0.statusName',
                        'value' => 'projectStatus0.statusName',
                        'contentOptions' => function ($data){
                                        if($data->projectStatus == 2){
                                       return ['style' => 'color: #808080; font-weight: bold; text-align: center; vertical-align: middle;' ];
                                        } elseif($data->projectStatus == 3) {
                                       return ['style' => 'color: #cc8800; font-weight: bold;text-align: center; vertical-align: middle;' ];
                                        } else {
                                       return ['style' => 'color: #87cd00; font-weight: bold;text-align: center; vertical-align: middle;' ];                                          }
                        }
                    ],
                    [
                        'attribute' => 'client.abr',
                        'label' => 'Client',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                        'format' => 'raw',
                        'value' => function ($data)
                                    {
                                         return $data->getClientName( $data->clientId );
                                    }
                    ],
                    [
                        'label' => 'Deadline',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'attribute' => 'deadline',
                        'value' => 'deadline',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;' ],
                    ],
                                ],
                            ] );
                            
?>
<?php pjax::end(); 
$this->registerJs("
    $(document).ready(function(){
                var currentUrl = $(location).attr('href');            
            $('#project-modal').on('hidden.bs.modal', function () {
                window.location.href  = currentUrl;
            });  

    });    
")?>
</div>