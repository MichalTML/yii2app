<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\UserAttendance;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserAttendance */

//$this->title = $model->userId;
$this->params['breadcrumbs'][] = ['label' => 'User Attendances', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-attendance-view">

    <?php
//    var_dump($dataProvider);
//    var_dump(UserAttendance::getCallendarInfo());

   
    ?>
    <div class="jumbotron">

        <div class="col-lg-12 border" style="padding: 0; margin-top: 50px;">     
            <div class="row" style="margin:auto;">
                
                <?php

        //$day = date("l", mktime(0, 0, 0, date("m"), $i, date("Y")));
        $dayName = ['Monday','Tuesday','Wednesday','Thursday','Friday', 'Saturday','Sunday'];
        for($d = 0; $d <= 6; $d++){
            echo '<div class="col-lg-1">' . $dayName[$d] . '</div>';
        }
      
    ?>
        </div>
    </div>     

</div>
</div>
