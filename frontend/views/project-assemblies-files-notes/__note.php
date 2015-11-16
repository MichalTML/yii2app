<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\label\LabelInPlace;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="project-notes-form">
    
    <?php
    if(isset($privnote)){
        $form = ActiveForm::begin(['id' => $model->formName(), 'enableClientValidation'=>false, 'enableAjaxValidation'=>true]); 
    echo $form->field($model, 'typeId')
              ->dropDownList( $model->getTypeList(2), ['rows' => '2', 'maxlength' => 255, 'style' => '' ] );   
    } elseif(isset($option)){
         $config = ['template'=>"{input}{error}"];
                 $form = ActiveForm::begin([
                        'id' => 'login-form-horizontal', 
                        'type' => ActiveForm::TYPE_INLINE,
                        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
                 ]);  
                  ?>
                    <div style="margin-bottom: 20px;">
                    <?= $form->field($noteLabel, 'labelName', $config)->widget(LabelInPlace::classname(),[
                            'label' => 'New Label Name',
                             ]);
                    ?>
                    <?= Html::submitButton('New Label', 
                        ['data-url' => Url::toRoute( ['project-assemblies-files-notes/note'] )
                        ,'class' => 'btn btn-success groupe-create group-button', 'title' => 'Create new group']);                    
                    ?>
                    </div>
    <?php
                    ActiveForm::end();
                    $form = ActiveForm::begin(['id' => $model->formName(), 'enableClientValidation'=>false, 'enableAjaxValidation'=>true]); 
        echo $form->field($model, 'typeId')
              ->dropDownList( $model->getTypeList(3), ['rows' => '2', 'maxlength' => 255, 'style' => '' ] ); 
        
        echo $form->field($model, 'labelId')
              ->dropDownList( $model->getLabelList(), ['rows' => '2', 'maxlength' => 255, 'style' => '' ] );  
    }else {
    echo $form->field($model, 'typeId')
              ->dropDownList( $model->getTypeList(0), ['rows' => '2', 'maxlength' => 255, 'style' => '' ] );   
    } ?>
    
    <?= $form->field($model, 'note')->textarea(['rows' => '2', 'maxlength' => 255, 'style' => 'resize:none']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'id' => 'create-note', 'name' => 'noteMe', 'value' => 'save-note']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= GridView::widget([
     'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{pager}",
        'rowOptions' => ['style' => 'text-align: center;'],
        'showHeader' => false,
        'export' => FALSE,
        'bootstrap' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns'=>false,
        'emptyText' => '<span style="text-align:center">No Notes found</span>', 
        'emptyTextOptions' => ['style' => 'text-align:center;'],
        'columns' => [
            [
                'value' => 'type.type',
                'label' => 'typeId',
                'contentOptions' => ['style' => 'width:150px; font-size: 10px; vertical-align: middle; font-weight: bold']
                
            ],
[
                'value' => function($model){
                                   if(isset($model->labelId)){
                                       if(!empty($model->note)){
                                           return $model->getLabelName($model->labelId) . ': ' . $model->note;
                                       }
                                       return $model->getLabelName($model->labelId);
                                   }
                                   return $model->note;
                },                                 
                      
                'label' => 'Note Content',
                'contentOptions' => function($model){
                                            if($model->statusId == 1 || $model->typeId == 2){
                                    return ['style' => 'word-wrap: break-word; overflow: hidden; max-width:200px; font-size: 14px; vertical-align: middle;'];
                                            }
                                    return ['style' => 'font-weight: bold; word-wrap: break-word; overflow: hidden; max-width:200px; font-size: 14px; vertical-align: middle;'];
                },
                
            ],
            [
                'value' => 'creUser.username',
                'label' => 'Created by',
                'contentOptions' => ['style' => 'color: #87cd00; width:60px; font-size: 10px; vertical-align: middle;']
                
            ],
            [
                'value' => 'creTime',
                'label' => 'Created at',
                'contentOptions' => ['style' => 'width:50px; white-space: nowrap; font-size: 10px; vertical-align: middle;']
                
            ],
           
            
            
        ]
]);
?>

<?php
if(isset($option)){
    $this->registerJs(
    '   $(".form-group .col-sm-10").removeClass();
        $("#create-note").click(function(){
       // $("#create-note").attr("name", "note-me");
    var $note = $("#projectassembliesfilesnotes-note").val();
        $("#modal-window").modal("hide");    
    });'
    );
} else {
    $this->registerJs(
    '$("#create-note").click(function(){
       // $("#create-note").attr("name", "note-me");
    var $note = $("#projectassembliesfilesnotes-note").val();
        if($note.length > 0){  
        $("#modal-window").modal("hide");
        }
    
    });'
    );
}
    
?>

