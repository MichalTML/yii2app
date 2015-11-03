<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\assets\FontAwesomeAsset;
use common\models\PermissionHelpers;
use yii\bootstrap\Modal;
use yii\helpers\Url;

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
    <div class="wrap-menu">
        
        <?php
        // IF USER IS A GUEST brand--> login else brand --> main page    
        if(Yii::$app->user->isGuest){             
               NavBar::begin([
                'brandLabel' => "<div class='menu-logo'><img src='".Yii::getAlias('@web')."/images/logo_pm.png'></img></div>",
                'brandUrl' => ['site/login'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top nav-border',
                ],]);  
        } else {
             NavBar::begin([
                'brandLabel' => "<div class='menu-logo'><img src='".Yii::getAlias('@web')."/images/logo_pm.png'></img></div>",
                'brandUrl' => ['site/main'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top nav-border',
                ],                
            ]);  
             
           }         
            
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '', 'url' => ['site/index'], 'options' => ['class' =>'fa fa-user', 'title' => 'new note'], 'title' => 'adasda'];
                $menuItems[] = ['label' => '', 'url' => ['/site/signup'], 'options' => ['title' => 'sign up']];
                $menuItems[] = ['label' => '', 'url' => ['site/login'], 'options' => ['title' => 'sign up']];
            } else {
                $menuItems[] = ['label' => '', 'url' => ['/site/main'], 'options' => ['class' =>'home', 'title' => 'home page' ]];
                $menuItems[] =  '<li class="profile">'.Html::button( '', 
                ['value' => Url::toRoute( ['project/listme']), 'id' => 'project-list', 
                'title' => 'Projects list' ] ).'</li>';
            }
                $menuItems[] = ['label' => '', 'url' => ['#'], 'options' => ['class' => 'refresh', 'title' => 'refresh page' ]];
                $menuItems[] = ['label' => '', 'url' => ['/site/contact'], 'options' => ['class' =>'help', 'title' => 'help form' ],];
                $menuItems[] = ['label' => '', 'url' =>['profile/view'], 'options' => ['class' =>'profile', 'title' => 'profile settings' ]];
            if ( PermissionHelpers::requireMinimumPower( Yii::$app->user->identity->id ) >= 40 ){                
                $menuItems[] =  '<li class="profile">'.Html::button( '', ['value' => Url::toRoute( ['project-scanner/upload']), 'id' => 'upload-button', 'title' => 'Import Project' ] ).'</li>';
            }
                $menuItems[] = ['label' => '(' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'options' => ['class' =>'logout', 'title' => 'log out' ],
                                'linkOptions' => ['data-method' => 'post']];
            
            
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
                    <a href="mailto:info@tma-automation.com">
                    <div class="tma-kontakt-email">
                        info@tma-automation.com
                   </div>
                    </a>
                  
                </div>
                
              <!-- SEcond Line -->
              
                <div class="col-md-12 pull-left" style="min-width: 620px">
                    <a href="http://www.TMA-AUTOMATION.com">
                        <div class="tma-kontakt-site">
                           www.tma-automation.com  
                        </div>
                    </a>
                    
                    <div class="tma-kontakt-stopka" style="float: right;">
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
<?php 

Modal::begin( [
    'id' => 'upload-modal',
    'closeButton' => false,
    'headerOptions' => ['style' => 'display:none'],
] );
echo "<div id='modalContent'></div>";
Modal::end();

Modal::begin( [
    'size' => Modal::SIZE_LARGE,
    'id' => 'project-modal',
    'closeButton' => false,
    'headerOptions' => ['style' => 'display:none'],
] );
echo "<div id='modalContent'></div>";

Modal::end();
        
$this->endPage() ?>
