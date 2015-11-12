<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\label\LabelInPlace;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\FileGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-group-form">
    <?php Pjax::begin(['id' => 'pjax-group-form', 'timeout' => false,
'enablePushState' => false]); ?>
    <?php
    
    $config = ['template'=>"<span class='col-sm-10 group-creation'>{input}{error}</span>"];
    $form = ActiveForm::begin([
        'id' => 'login-form-horizontal', 
        'type' => ActiveForm::TYPE_INLINE,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);  
    ?>
    <div style="margin-bottom: 20px;">
    <?= $form->field($modelGroup, 'groupName', $config)->widget(LabelInPlace::classname(),[
            'label' => 'Group',
             ]);
    ?>
    <?= Html::submitButton('Create', ['class' => 'btn btn-success groupe-create group-button', 'title' => 'Create new group']); ?>
    </div>
    <div class="delete-group" style="margin-bottom: 20px;">
    <?=  $form->field( $modelGroup, 'groupId', $config )
          ->dropDownList( $droptions, ['prompt' => '' ] )
     ?> 
    <?= Html::submitButton('Delete', ['class' => 'btn btn-success groupe-delete group-button', 'title' => 'Delete group']); ?>
    </div>
    <div class="add-group">
    <?=  $form->field( $modelGroup, 'groupId', $config )
          ->dropDownList( $droptions, ['prompt' => '' ] )
     ?>
    
        <?= Html::submitButton('Select', ['class' => 'btn btn-success groupe-add group-button', 'title' => 'Add Files to Group']); ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="syg-info" hidden="hidden"><?php echo $sygnature ?></div>
    <div class="id-info" hidden="hidden"><?php echo $id ?></div>
</div>

<?php
$this->registerJs('$(".groupe-create").click(function(event){   
    
                    event.preventDefault();
                    var groupName = $("#filegroupname-groupname").val(); 
                        if(groupName.length > 0){

                            var sygnature = $(".syg-info").html();
                            var id = $(".id-info").html();
                            var action = "save_name";
                            var url = "index.php?r=file-group-name/create&sygnature=" + sygnature + "&id=" + id;
                                $.ajax({
                                    url: url,
                                    type: "post",
                                    data: {action: action, groupName: groupName},
                                    success: function(msg) {
                                        $(".delete-group #filegroupname-groupid").empty();
                                        $(".delete-group #filegroupname-groupid").append("<option value=\\"\\"></option>");
                                        $(".add-group #filegroupname-groupid").empty();
                                        $(".add-group #filegroupname-groupid").append("<option value=\\"\\"></option>");
                                            $.each(msg.droptions, function(key, value) { 

                                                if(value.length > 0 ){
                                                    $(".delete-group #filegroupname-groupid").append("<option value=" + key + ">" + value + "</option>");
                                                }
                                            });
                                            $.each(msg.droptions, function(key, value) { 
                                                if(value.length > 0 ){
                                                        $(".add-group #filegroupname-groupid").append("<option value=" + key + ">" + value + "</option>");
                                                }
                                            });
                                            }
                        });
                        }
                });
                
                $(".groupe-delete").click(function(event){   
                    event.preventDefault();
                    var groupId = $(".delete-group #filegroupname-groupid").val(); 
                        if(groupId.length > 0){

                            var sygnature = $(".syg-info").html();
                            var id = $(".id-info").html();
                            var action = "delete_name";
                            var url = "index.php?r=file-group-name/create&sygnature=" + sygnature + "&id=" + id;
                            $.ajax({
                                    url: url,
                                    type: "post",
                                    data: {action: action, groupId: groupId},
                                 success: function (msg) {
                                        $(".delete-group #filegroupname-groupid").empty();
                                        $(".delete-group #filegroupname-groupid").append("<option value=\\"\\"></option>");
                                        $(".add-group #filegroupname-groupid").empty();
                                        $(".add-group #filegroupname-groupid").append("<option value=\\"\\"></option>");
                                            $.each(msg.droptions, function(key, value) { 

                                                if(value.length > 0 ){
                                                    $(".delete-group #filegroupname-groupid").append("<option value=" + key + ">" + value + "</option>");
                                                }
                                            });
                                            $.each(msg.droptions, function(key, value) { 
                                                if(value.length > 0 ){
                                                        $(".add-group #filegroupname-groupid").append("<option value=" + key + ">" + value + "</option>");
                                                    }
                                            });                                         
                                    }
                                });
                                }
                });
                
                $(".groupe-add").click(function(event){   
                    event.preventDefault();
                    var groupId = $(".add-group #filegroupname-groupid").val(); 
                        if(groupId.length > 0){

                            var sygnature = $(".syg-info").html();
                            var id = $(".id-info").html();
                            var action = "add_group";
                            var url = "index.php?r=file-group-name/create&sygnature=" + sygnature + "&id=" + id;
                                $.ajax({
                                    url: url,
                                    type: "post",
                                    data: {action: action, groupId: groupId},
                                    success: function (msg) {
                                        $(".add-group #filegroupname-groupid").empty();
                                        $(".add-group #filegroupname-groupid").append("<option value=\\"\\"></option>");
                                        $.each(msg.droptions, function(key, value) { 

                                    if(value.length > 0 ){
                                        $(".add-group #filegroupname-groupid").append("<option value=" + key + ">" + value + "</option>");
                                    }
                                });                                           
                            }
                            }); 
                        }
                });
                
');

$this->registerJs('$(document).on("pjax:timeout", function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});');

pjax::end();