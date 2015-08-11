<?php

//use \yii\bootstrap\Modal;
//use kartik\social\FacebookPlugin;
//use \yii\bootstrap\Collapse;
//use \yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
$this->title = 'TMA Project Manager';
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
                    if(PermissionHelpers::requireMinimumPower(Yii::$app->user->identity->id) > 10) {
                        echo Html::a('<div class="mainbox-pm">'
                                . '<div class="btn btn-default">Project manager</div>'
                                . '<div class="mainbox_info"><span>Project Manager</span>
                                    - Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Sed molestie mi velit, et tincidunt neque mollis et. 
                                  </div>'
                                . '</div>', ['project/index']);
                    }
                    
                    ?>
                    </div>
                    <div class="col-lg-4 col-sm-5 col-xs-5" style="min-width: 345px;">               

<?php
    echo Html::a('<div class="mainbox-cm">'
                                . '<div class="btn btn-default">Client Manager</div>'
                                . '<div class="mainbox_info"><span>Client Manager</span> 
                                    - Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Sed molestie mi velit, et tincidunt neque mollis et.  
                                  </div>'
                                . '</div>', ['site/clients']);              
 ?>
                    </div>
 
    
                                     

                    
                    </div>
                </div>
            </div>       
        </div>





