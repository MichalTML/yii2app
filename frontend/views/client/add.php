<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientData */

$this->title = 'Create New Client';
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create new project', 'url' => ['project/create']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_addform', [
        'model' => $model,
        'newClientNumber' => $newClientNumber,
    ]) ?>

</div>
