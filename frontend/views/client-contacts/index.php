<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PermissionHelpers;
use frontend\models\Gender;
use yii\helpers\ArrayHelper;
use frontend\models\ClientContacts;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ClientContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Clients Manager', 'url' => ['site/clients']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contacts-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('New Contact', ['create'], ['class' => 'btn btn-success']) ?>
    </p> 
   <?php
   $ClientContacts = new ClientContacts;
   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items} {pager}',
        'headerRowOptions' => ['style' => 'font-size: 10px' ],
        'rowOptions' => ['style' => 'font-size: 10px' ],
       'export' => FALSE,  
    'bootstrap' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
        
        'columns' => [
             [
                        'attribute' => 'client.name',
                        'label' => 'Client',
                        'headerOptions' => ['style' => 'text-align: center;' ],
                        'contentOptions' => ['style' => 'color: #337ab7;text-align: center; line-height: 2.5em;' ],
                        'format' => 'raw',
                        'value' => function ($data)
                {
                    return Html::button( $data->getClientName( $data->clientId ), ['value' => Url::toRoute( ['client/detail', 'id' => $data->clientId ] ), 'class' => 'client-button', 'id' => 'clientButton' ] );
                },
                    ],
            [
                'label' => 'First Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'firstName',
                'value' => 'firstName',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
             [
                'label' => 'Last Name',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'lastName',
                'value' => 'lastName',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
            
            [
                'label' => 'Gender',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'gender.genderName',
                'value' => 'gender.genderName',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter' => Html::activeDropDownList($searchModel, 'gender.genderName', ArrayHelper::map(Gender::find()->asArray()->all(),
                'genderName','genderName'),['class'=>'form-control', 'prompt' => ' ', 'style' => 'width: 100px;']),
            ],
            [
                'label' => 'Phone',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'phone',
                'value' => 'phone',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
            [
                'label' => 'Email',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'email',
                'format' => 'email',
                'value' => 'email',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
             [
                'label' => 'Department',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'department',
                'value' => 'department',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
            [
                'label' => 'Position',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'position',
                'value' => 'position',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
            [
                'label' => 'Created By',
                'headerOptions' => ['style' => 'text-align: center;'],
                'attribute' => 'creUser.username',
                'value' => 'creUser.username',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header' => '',
                'headerOptions' => ['style' => 'min-width: 90px;text-align: center; border-bottom-color: transparent;' ],
                'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;' ],
                'template' => '{view} {edit} {delete}',
                'buttons' => [
                            'delete' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'data-method' => 'post',
                                        'title' => Yii::t( 'app', 'delete' ),
                                        'data' => [
                                            'confirm' => 'You are about to delete: ' . $model->firstName . ' ' . $model->lastName . 
                                            ', are you sure you want to proceed?',
                                            'method' => 'post',
                                        ],
                                    ] );
                        } else
                        {
                            return '<i class="glyphicon glyphicon-trash"></i>';
                        }
                    },
                            'edit' => function($url, $model)
                    {
                        if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 15 )
                        {
                            return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, 
                            [ 'data-method' => 'post', 
                                'title' => Yii::t( 'app', 'edit' ) ] );
                        } else
                        {
                            return '<i class="glyphicon glyphicon-pencil"></i>';
                        }
                    },
                            'view' => function($url, $model)
                    {
                        return Html::button( '<a href="#"><i class="glyphicon glyphicon-eye-open"></i></a>', 
                        ['value' => $url, 'class' => 'view-button', 'id' => 'view-button', 'title' => 'view' ] );
                    }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index)
                {
                    if ( $action === 'delete' )
                    {
                        $url = Url::toRoute( ['client-contacts/delete', 'id' => $model->id ] );
                        return $url;
                    }
                    if ( $action === 'edit' )
                    {
                        $url = Url::toRoute( ['client-contacts/update', 'id' => $model->id ] );
                        return $url;
                    }
                    if ( $action === 'view' )
                    {
                        $url = Url::toRoute( ['client-contacts/view', 'id' => $model->id ] );
                        return $url;
                    }
                }
                    ],
        ],
    ]);
   ?>
   

</div>
<?php

$this->registerJs("$(function(){
    // get the click event of the Note button
    $('.view-button').click(function(){
        $('#view-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});
$(function(){
    // get the click event of the Note button
    $('.client-button').click(function(){
        $('#client-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});");
    
        Modal::begin( [
            'id' => 'view-modal',
            'header' => '<h4 class="modal-title">Client Details</h4>',
        ] );
        echo "<div id='modalContent'></div>";

        Modal::end();
        
        Modal::begin( [
            'id' => 'client-modal',
            'header' => '<h4 class="modal-title">Client Detail View</h4>',
        ] );
            echo "<div id='modalContent'></div>";
            Modal::end();
        