<?php
use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use \yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'TMA Project Manager';
?>

<div class="site-index">
  <div class="jumbotron">
      <?php if (Yii::$app->user->isGuest) {
          echo Html::a('Get Started Today', ['site/signup'],
      ['class' => 'btn btn-lg btn-success']);}?>
      
      <h1>TMA CM</h1>
      
      <p class="lead">Start of TMA CM project.</p>
      
      <br />
      
      
      
      
      
      
      
  </div>
</div>





