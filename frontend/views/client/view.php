<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = ['label' => 'Actual Clients List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<?php if(PermissionHelpers::requireMinimumPower(Yii::$app->user->identity->id) > 30) {    
    echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . ' ';
       echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
        
 } else { 
        echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
 } ?>
        
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'clientNumber',
            'name',
            'abr',
            'adress',
            'city',
            'postal',
            'phone',
            'fax',
            'email:email',
            'nip',
            'krs',
            'regon',
            'www',
            'description',
            'creTime',
            'updTime',
            'creUser.username',
            'updUser.username',
            
            
        ],
    ]) ?>

</div>
