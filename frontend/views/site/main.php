<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use \yii\helpers\Html;
use yii\web\NotFoundHttpException;

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
        
        <div class="well">
            Basic instructions go here.
            <br/>
            Basic instructions go here.
            <br/>
            Basic instructions go here.
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
    

echo Html::a( 'Project manager', ['project/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                * Project managing cetner. You can do here all things that are related to Projects.
                        </div>              

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Client manager', ['site/clients'], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                * This is the place to review, and manage whole Client list.
                        </div>            

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( '--------------------', [''], ['class' => 'btn btn-default' ] );
?>




                       <div class="mainbox_info">
                                *--------------------.
                        </div>            

                    </div>

                </div>
            </div>

                <div class="row">
                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( '--------------------', ['' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( '--------------------', ['' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( '--------------------', [''], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *--------------------.
                        </div>             

                    </div>

                </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>





