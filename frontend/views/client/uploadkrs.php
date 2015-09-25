<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/**
 * @var yii\web\View $this
 * @var backend\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="product-form">

    <!--change here: This form option need to be added in order to work with multi file upload ['options' => ['enctype'=>'multipart/form-data']]-->
    <?php $form = ActiveForm::begin(['id' => $model->formName(), 'enableClientValidation'=>false, 'enableAjaxValidation'=>false, 'options' => ['enctype'=>'multipart/form-data']]); ?>

    <?php

    // Usage with ActiveForm and model
    //change here: need to add image_path attribute from another table and add square bracket after image_path[] for multiple file upload.
     echo $form->field($model, 'path')->widget(FileInput::classname(), [
        'options' => ['multiple' => false, 'accept' => 'pdf'],
        'pluginOptions' => [
            //change here: below line is added just to hide upload button. Its up to you to add this code or not.
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

