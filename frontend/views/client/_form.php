<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-data-form">
<?php
$model->clientNumber = $newClientNumber;
?>
<div class ="create-form col-lg-10">
    <?php
        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    ?>
    
    
    
    <?php
        $config = ['template'=>"<span class='col-sm-4'>{input}{error}</span>"]; // config to deactivate label for ActiveField
        $configDescription = ['template'=>"<span class='col-sm-8'>{input}{error}</span>"]; // config to deactivate label for TextField
    ?> 
    
<div class="row">
    <div class="form-group">
    
        <?= $form->field($model, 'clientNumber', $config
            )->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('clientNumber').' e.g. <span style="color: #87cd00; font-weight: normal">0101</span>',
             ]);  
        ?>
    </div>
</div>
    
<div class="row">
    
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Name data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'abr', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('abr'),
             ]);  
        ?>
        <?= $form->field($model, 'name', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('name'),
             ]);  
        ?>    
    </div>
</div>

<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Correspondence data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'adress', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('adress'),
             ]);  
        ?>
        <?= $form->field($model, 'city', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('city'),
             ]);  
        ?>   
        <?= $form->field($model, 'postal', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('postal'),
             ]);  
        ?>   
    </div>
</div>

<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Contact data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'phone', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('phone'),
             ]);  
        ?>
        <?= $form->field($model, 'fax', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('fax'),
             ]);  
        ?>   
        <?= $form->field($model, 'email', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('email'),
             ]);  
        ?>   
    </div>
</div>
  
<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Registration data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'nip', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('nip'),
             ]);  
        ?>
        <?= $form->field($model, 'krs', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('krs'),
             ]);  
        ?>   
        <?= $form->field($model, 'regon', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('regon'),
             ]);  
        ?>   
    </div>
</div>
    
<div class="row">
    
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Additional data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'www', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('www'),
             ]);  
        ?>
        <?= $form->field($model, 'description', $configDescription)->widget(LabelInPlace::classname(),[
        'label' => $model->getAttributeLabel('description').' e.g.',
        'type' => LabelInPlace::TYPE_TEXTAREA
    ]);  ?>    
    </div>
</div>    

<div class="row">
    <div class="form-group">
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', 
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ).' ' ?>
        <?php 
        if( $model->isNewRecord == true ){
            echo Html::submitButton( 'Add contact' , ['class' => 'btn btn-info', 'name' => 'add']).' ' ; 
        } 
        ?>
    </div>
</div>    
<?php ActiveForm::end(); ?>
    
</div>
    
</div>
