<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use \yii\helpers\Html;
use yii\web\NotFoundHttpException;

/* @var $this yii\web\View */
$this->title = 'Other Tools';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index">
    <div class="jumbotron">
        
   <div class="col-lg-12" style="min-width: 700px; padding: 0; margin-top: 50px;">     
<div class="row" style="margin-top: 100px">
            
<?php
if(Yii::$app->user->isGuest){
    throw new NotFoundHttpException( 'Please login to view this page.' );
}?>
                    <div class="col-lg-4 col-sm-5 col-xs-5" style="min-width: 345px;">
                    <?php
                        echo Html::a('<div class="mainbox-att">'
                                . '<div class="btn btn-default">User Attendance</div>'
                                . '<div class="mainbox_info"><span>User Attendance</span>
                                    - Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Sed molestie mi velit, et tincidunt neque mollis et. 
                                  </div>'
                                . '</div>', ['user-attendance/index']);
                    ?>
                    </div>               

    
                                     

                    
                    </div>
                </div>
            </div>       
        </div>






