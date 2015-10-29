<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProjectNotes */
/* @var $form yii\widgets\ActiveForm */
?>

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

<?php
    $this->registerJs(
    '$("#create-note").click(function(){
    var $note = $("#projectassembliesfilesnotes-note").val();
        if($note.length > 0){  
             $("#modal-window").modal("hide");
        }
    
    });'
    );
?>

