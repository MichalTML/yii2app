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
use yii\web\UrlManager;

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
    <div class="wrap-action">
        
        <?php
        // IF USER IS A GUEST brand--> login else brand --> main page    
        if(Yii::$app->user->isGuest){             
               NavBar::begin([
                'brandLabel' => '<div class="menu-logo"><img src="http://www.tma-automation.com/wp-content/themes/TM-Automation/images/logo_pm.png"></img></div>',
                'brandUrl' => ['site/login'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top nav-border',
                ],]);  
        } else {
             NavBar::begin([
                'brandLabel' => '<div class="menu-logo"><img src="http://www.tma-automation.com/wp-content/themes/TM-Automation/images/logo_pm.png"></img></div>',
                'brandUrl' => ['site/main'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top nav-border',
                ],                
            ]);  
             
           }         
            
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '', 'url' => ['site/index'], 'options' => ['class' =>'fa fa-user']];
                $menuItems[] = ['label' => '', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => '', 'url' => ['site/login']];
            } else {
                $menuItems[] = ['label' => '', 'url' => ['/site/main'], 'options' => ['class' =>'home']];
                $menuItems[] = ['label' => '', 'url' => ['/site/contact'], 'options' => ['class' =>'help'],];
                $menuItems[] = ['label' => '', 'url' =>['profile/view'], 'options' => ['class' =>'profile']];
                //$menuItems[] = ['label' => 'Administration', 'url' =>[\Yii::$app->urlManagerBackEnd->baseUrl]];
//                $menuitems[] = ['label' => 'Create Profile', 'url' =>['/profile']]
                $menuItems[] = ['label' => '(' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'options' => ['class' =>'logout'],
                                'linkOptions' => ['data-method' => 'post']];
            }
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
            <div style="margin-top: 100px;"></div>
        <?= $content ?>
        </div>
    </div>
    

    <footer class="footer-menu">
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
