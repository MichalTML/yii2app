<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\FileGroupName */

$this->title = 'Create File Group Name';
$this->params['breadcrumbs'][] = ['label' => 'File Group Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-name-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
