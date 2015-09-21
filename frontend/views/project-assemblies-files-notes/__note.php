<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<?php Pjax::begin() ?>

<div class="project-notes-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName(), 'enableClientValidation'=>false, 'enableAjaxValidation'=>true,

]); ?>
    
    <?= $form->field($model, 'typeId')->dropDownList( $model->getTypeList(), ['prompt' => '' ] ) ?> 
    
    <?= $form->field($model, 'note')->textarea(['rows' => '6', 'maxlength' => 255, 'style' => 'resize:none']) ?>
    

    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'id' => 'create-note']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Pjax::end() ?>
<?php
    $this->registerJs(
    '$("#create-note").click(function(event){
    var $type = $("#projectassembliesfilesnotes-typeid").val();
    var $note = $("#projectassembliesfilesnotes-note").val();
    
    if($type.length > 0 || $note.length > 0){  
         $("#cmodal").modal("hide");
    }
    
    });'
    );
?>
<script>
    function submitForm($form) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function(result) {
            $('#modalreference-edit').modal('hide');
            
        })
        .fail(function() {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut();
        });
    return false;
}    
</script>
