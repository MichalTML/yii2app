<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\jui\DatePicker;
use kartik\label\LabelInPlace;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-data-form">
    
<?php
$model->sygnature = $freeId;
?>
    
<div class ="create-form col-lg-10" style="font-size: 12px">
    <?php
        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    ?>  

    <?php
        $config = ['template'=>"<span class='col-sm-4'>{input}{error}</span>"];
    ?> 
    
<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Client data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field( $model, 'clientId', $config )
            ->dropDownList( $model->getClientList(), ['prompt' => '' ] ) 
        ?>  
        <?= Html::a( 'Add client', ['client/add' ],
            ['class' => 'btn btn-default']); 
        ?>     
        <?= Html::a( 'Promote client', ['o-client-data/promote' ],
            ['class' => 'btn btn-default']); 
        ?>     
    </div>
</div>  
        
<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Naming data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field($model, 'sygnature', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('sygnature'),
             ]);  
        ?>
        <?= $form->field($model, 'projectName', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => $model->getAttributeLabel('projectName'),
             ]);  
        ?>   
    </div>
</div>

<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Execution data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?=
         $form->field( $model, 'projectStart', $config )->widget( DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => 
                ['class' => 'date-style', 'placeholder' => 'Project Start Date'],
        'clientOptions' => [
        'yearRange' => '-115:+0',
        'changeYear' => true ]
        ] )
        ?>  
        
        <?= $form->field($model, 'deadline', $config)->widget(LabelInPlace::classname(),[
            'encodeLabel' => false,
            'label' => 'Project Duration (weeks)',
             ]);  
        ?> 
        
        <?= Html::input('text','','',
        ['id' => 'deadline-field', 'class'=>'form-control', 'placeholder' => 'deadline', 'disabled' => 'disabled', 'style' => 'width: 200px'])?>
    </div>
</div>
  
<div class="row">
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Status data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <?= $form->field( $model, 'projectStatus', $config )
          ->dropDownList( $model->getStatusList(), ['prompt' => '' ] )
        ?>      
    </div>
</div>
    
<div class="row">
    
    <div class="form-group">
        <span style="text-shadow: 0px 1px white; font-weight: bold; position: absolute; margin-top:-20px">Constructors data:</span>
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
        <div class="col-sm-4">
        <?=
        $form->field( $projectPermissions, 'userId', ['template' => "<span class='checkbox'>{input}</span>" ] )
                ->checkboxList( $model->getConstructorList(), $options = ['separator' => ' ']
        );
        ?> 
        </div>
    </div>
</div>    

<div class="row">
    <div class="form-group">
        <hr style="height: 1px; border: 0; box-shadow: inset 0 12px 12px -12px #87cd00">
         <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', 
             ['class' => $model->isNewRecord ? 'btn btn-default login' : 'btn btn-default login' ] ) 
         ?>
    </div>
</div>    
<?php ActiveForm::end(); ?>
    
</div>
    
</div>

<?php
$this->registerJs("$('#projectdata-deadline').on('change', function(){  
                    var startDate = $('#projectdata-projectstart').val();
                    var value = $('#projectdata-deadline').val() * 7;
                    if(Math.floor(value) == value && $.isNumeric(value) && startDate.length > 1){ 
                        
                        
                        var data = new Date(startDate);
                        var day = data.getDate() + value;
                        data.setDate(day);
                        var month = data.getMonth() + 1;
                        if(data.getMonth() < 9){
                            var deadline = data.getFullYear() + '-0' + month;
                        } else {
                            var deadline = data.getFullYear() + '-' + month;
                        }
                        if(data.getDate() < 9){
                            var deadline = deadline + '-0' + data.getDate();
                        } else {
                            var deadline = deadline + '-' + data.getDate();
                        }
                        $('#deadline-field').attr('value', deadline);
                    }
                    });
                    $('#projectdata-projectstart').on('change', function(){    
                    var value = $('#projectdata-deadline').val() * 7;
                    if(Math.floor(value) == value && $.isNumeric(value)){ 
                        var startDate = $('#projectdata-projectstart').val();
                        var value = $('#projectdata-deadline').val() * 7;
                        var data = new Date(startDate);
                        var day = data.getDate() + value;
                        data.setDate(day);
                        var month = data.getMonth() + 1;
                        if(data.getMonth() < 8){
                            var deadline = data.getFullYear() + '-0' + month;
                        } else {
                            var deadline = data.getFullYear() + '-' + month;
                        }
                        if(data.getDate() < 9){
                            var deadline = deadline + '-0' + data.getDate();
                        } else {
                            var deadline = deadline + '-' + data.getDate();
                        }
                        $('#deadline-field').attr('value', deadline);
                    }
                    });
                    ");
