<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-notes-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
    
    <?= $form->field($model, 'title')->textInput() ?>
    
    <?= $form->field($model, 'note')->textarea(['rows' => '6', 'maxlength' => 255, 'style' => 'resize:none']) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$script = <<< JS
        
        $('form#{$model->formName()}').on('beforeSumbit', function(e)
        {
        var \$form = $(this);
        $.post(
            \$form.attr("action"), 
            \$form.serialize()
        )
            .done(function(result) {
        console.log(result);
//            if(reuslt.message == 'Success')
//        {
//            $(document).find('#secondmodal').modal('hide');
//            $.pjax.reload({container:'#commodity-grid'});
//        }else
//        {
//            $(\$form).trigger("reset");
//            $("#message").html(result.message);
//        }
        }).fail(function()
        {
            console.log("server error");
        });
        return false;
        });
        
JS;
        
$this->registerJS($script);

?>
