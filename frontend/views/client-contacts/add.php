<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClientContacts */

$this->title = 'Create Client Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Project list', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create new project', 'url' => ['project/create']];
$this->params['breadcrumbs'][] = ['label' => 'Create new client', 'url' => ['client/add']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-create">

    

    <?= $this->render('_addform', [
        'model' => $model,
    ]) ?>

</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

