<?php

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserAttendance */

//$this->title = $model->userId;
$this->params[ 'breadcrumbs' ][] = ['label' => 'User Attendances', 'url' => ['index' ] ];
$this->params['breadcrumbs'][] = $user->firstName . ' '. $user->lastName ;
?>
<div class="user-attendance-view">
    <div class="row">
        <div class='col-lg-10 col-sm-10 col-xs-10' style="margin-bottom: 50px;">
 <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
//      'events'=> $events,
      'events'=> $events,
      'googleCalendar' => false, // If the plugin displays a Google Calendar. Default false
      'loading' => 'Loading...', // Text for loading alert. Default 'Loading...'
     
     'header' => [
        'center'=>'title',
        'left'=>'prev',        
        'right'=>'next',
    ],
      'options' => [
        // put your options and callbacks here
        // see http://arshaw.com/fullcalendar/docs/
        'lang' => 'eng', // optional, if empty get app language
        'titleFormat' => 'MMMM YYYY',
        'basicWeek' => false,
        'height' => '500',
          'contnetHeight' => '50',
        
    ],
  ));
  ?>
                
    </div>
    <div class='col-lg-2 cols-xs-2'>
        <br/>
        <br/>
        <br/>
        <?php
        // Using a select2 widget inside a modal dialog
Modal::begin([
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
    ],
    'header' => '<h4 style="margin:0;">Raport options</h4>',
    'toggleButton' => ['label' => '', 'class' => 'btn btn-lg btn-primary pdf-button'],
    'closeButton' => false,
]);
?>
        
<?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<div class="row">
    <cdiv lass = "form-group">
    
    <div class="col-sm-4">
        <?= $form->field($model, 'month', ['showLabels'=>false])->widget(Select2::classname(), [
            'data'=> $model->getMonths(),
            'theme' => 'bootstrap',
            'pluginOptions'=>
                [
                'allowClear'=>true,
                ],
            'options' =>
                [
                'placeholder'=>'Select month...',
                'hideSearch' => true,
                ]
        ]); ?>
        
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'year', ['showLabels'=>false])->widget(Select2::classname(), [
            'data'=> $model->getYear(),
            'theme' => 'bootstrap',
            'hideSearch' => true,
            'pluginOptions'=>['allowClear'=>true],
            'options' => ['placeholder'=>'Select year...']
        ]); ?>
        
    </div>
   
    <div class="col-sm-4">
        <?= Html::submitButton('Generate PDF', ['class' => 'btn btn-primary'],['target' => '_blank']) ?>  
    </div>
</div>
         </div>
    </div>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?> 
    </div>
</div>
