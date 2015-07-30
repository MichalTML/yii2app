<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>
<div class="site-login">
    

    <br />
    <br />
    <br />

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="well well-e">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Please fill out the following fields to login:</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>
                <div class="form-group">
                   
<?= Html::submitButton( 'Login', ['class' => 'btn btn-default login', 'name' => 'login-button'] ); ?>

                    </div>
                   
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
