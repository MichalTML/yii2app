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
        <br />
        <br />
        <br />

        <div class ="well well-e">
            <p><span>TMA Project Manager</span></p>
            <p><span>LOGO PLACE HOLDER</span></p>
        </div>
        
         <div class="well well-e message">
            <h3>Client Management panel</h3>
            <ul>
                <?php
if(Yii::$app->user->isGuest) {
    throw new NotFoundHttpException( 'Please login to view this page.' );
}?>
               <?php if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) > 10 ) {
               echo '<li>Project Manager - manage projects, add new clients and client contacts.</li>';
               }?>
                <li>Clients Manager - manage clients, clients contacts, other clients and their contacts. </li>
            </ul>
        </div>

    
        <br />
      
        
        <div class="body-content">

            <div class="row">

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
if(Yii::$app->user->isGuest) {
    throw new NotFoundHttpException( 'Please login to view this page.' );
}
    
if(PermissionHelpers::requireMinimumPower(Yii::$app->user->identity->id) > 10){
echo Html::a( 'Project manager', ['project/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                * Project manager zone.
                        </div>              

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
}
echo Html::a( 'Client manager', ['site/clients'], ['class' => 'btn btn-default' ] );
?>




                       <div class="mainbox_info">
                                * Client manager zone.
                        </div>            

                    </div>

                </div>

<!--                <div class="col-lg-4">

                    <div class="mainbox">-->


<?php
//echo Html::a( '--------------------', [''], ['class' => 'btn btn-default' ] );
?>




<!--                       <div class="mainbox_info">
                                *--------------------.
                        </div>            

                    </div>

                </div>
            </div>

                <div class="row">
                <div class="col-lg-4">

                    <div class="mainbox">-->


<?php
//echo Html::a( '--------------------', ['' ], ['class' => 'btn btn-default' ] );
?>



<!--
                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">-->


<?php
//echo Html::a( '--------------------', ['' ], ['class' => 'btn btn-default' ] );
?>

<!--


                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">-->


<?php
//echo Html::a( '--------------------', [''], ['class' => 'btn btn-default' ] );
?>

<!--


                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                </div>-->

            </div>
        </div>
    </div>
</div>





