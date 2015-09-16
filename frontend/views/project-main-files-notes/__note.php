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
    
    <?= $form->field($model, 'typeId')->textInput() ?>
    
    <?= $form->field($model, 'note')->textarea(['rows' => '6', 'maxlength' => 255, 'style' => 'resize:none']) ?>
    

    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'id' => 'create-note', 'data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Pjax::end() ?>

<script>
    function submitForm($form) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function(result) {
            //$form.parent().html(result.message);
            $('#modalreference-edit').modal('hide');
        })
        .fail(function() {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut();
        });
    return false;
}    
</script>
