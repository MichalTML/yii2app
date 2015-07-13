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
          echo Html::a('Getting started with TMA PM', ['site/signup'],
      ['class' => 'btn btn-lg btn-primary']);
      echo '<h1 style="text-shadow: 3px 3px silver;">TMA Project Manager</h1>';}?>      
    
      <br />
      <p class="lead">Instructions</p>
      <p class="lead">Basic How To</p>
      <p class="lead">Some generall ifno</p>
      <p class="lead">Some generall message</p>
      <br />
      
      
      
      
      
      
      
  </div>
</div>





