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

        <h1>TMA Project Manager</h1>
        <h2>Main menu</h2>

        <br />
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
                                *go here if you want to create/update/view/delete project.
                        </div>              

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Create New Project', ['user/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *go here if you want to create new project.
                        </div>            

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Create New Project', ['user/index' ], ['class' => 'btn btn-default' ] );
?>




                       <div class="mainbox_info">
                                *go here if you want to create new project.
                        </div>            

                    </div>

                </div>
            </div>

                <div class="row">
                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Create New Project', ['user/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *go here if you want to create new project.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Create New Project', ['user/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *go here if you want to create new project.
                        </div>             

                    </div>

                </div>
                    
                    <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Create New Project', ['user/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                *go here if you want to create new project.
                        </div>             

                    </div>

                </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>




