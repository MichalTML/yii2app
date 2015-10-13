<?php

use yii\widgets\DetailView;

?>
<div class="client-data-view">

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
            [
             'attribute' => 'website',
             'format' => 'raw',
             'value' => '<a target="_blank" href="http://'.$model->www.'">'.$model->www.'</a>',
                        
            ],
            'description',
            'creTime',
            'updTime',
            'creUser.username',
            'updUser.username',
            
            
        ],
    ]) ?>
    

</div>
