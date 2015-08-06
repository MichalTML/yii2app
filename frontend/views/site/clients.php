<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use \yii\helpers\Html;
use yii\web\NotFoundHttpException;

/* @var $this yii\web\View */
$this->title = 'Client Manager';
$this->params['breadcrumbs'][] = $this->title;
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
                <li>Clients - clients manager panel.</li>
                <li>Clients Contacs - clients contacts manager panel.</li>
                <li>Other Clients - go here to manage clients, that don`t directly cooperare with <span>TMA AUTOMATION</span>.</li>
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
    

echo Html::a( 'Clients', ['client/index' ], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                * Manage actual clients list.
                        </div>              

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Contacts', ['client-contacts/index'], ['class' => 'btn btn-default' ] );
?>




                        <div class="mainbox_info">
                                * Manage Contacts for actual aclients.
                        </div>            

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mainbox">


<?php
echo Html::a( 'Other clients', ['site/other-clients'], ['class' => 'btn btn-default' ] );
?>




                       <div class="mainbox_info">
                                *Manage prospect clients list.
                        </div>            

                    </div>

                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4"></div>
            <div class="col-lg-4">

                    <div class="go-back-button">


<?php
echo Html::a( 'Go back', ['site/main'], ['class' => 'btn btn-default' ] );
?>




                                 

                    </div>

                </div>

            </div>

            </div>
        </div>
    </div>
</div>





