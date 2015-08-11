<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\assets\FontAwesomeAsset;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
FontAwesomeAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?php \Yii::getAlias('@web') ?>/images/favicon.ico" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap-login">
      
        
        
        
        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    
    </div>

     <footer class="footer-login">
        <div class="container">
            <div class="row">
                <!-- TMA FOOT LOGO -->
<!--                <div class="col-md-1 cols-xs-1 pull-left">
                    <div class="tma-logo"></div>
                </div>-->
                
              <!-- FIRST LINE -->
            
              
                <div class="col-md-12 pull-left" style="margin-top:10px; min-width: 620px"> 
                    <div class="tma-kontakt-images email"></div>
                    
                    <div class="tma-kontakt">
                        <a href="mailto:info@tma-automation.com">info@tma-automation.com</a>
                    </div>
                </div>
                
              <!-- SEcond Line -->
            
           
                <div class="col-md-12 pull-left" style="min-width: 620px">
                    <div class="tma-kontakt-images site"></div>
                    <div class="tma-kontakt">
                        <a href="www.TMA-AUTOMATION.com">www.tma-automation.com</a>
                    </div>

                    <div class="tma-kontakt" style="float: right;">
                        <span style="text-align:right;">&copy; <?= date('Y') ?> TMA AUTOMATION Sp. z o.o.</span>
                    </div>
                </div>  
                
            
               <!-- THIRD LINE -->
            

              
            </div>    
           
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
