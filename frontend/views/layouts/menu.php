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
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap bg">
        
        <?php
            
        NavBar::begin([
                'brandLabel' => '<img syle="margin: 0; padding: 0px;" src="http://workspace.telemobile.pl/test/KAROL/RFswitchATT_Michal/Testing/images/logo.png"> Project Manager <i class="fa fa-plug"></i>',
                'brandUrl' => ['/site/main'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],                
            ]);            
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/main']],
                ['label' => 'Help', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['site/login']];
            } else {
                $menuItems[] = ['label' => 'Profile', 'url' =>['/profile/view']];
//                $menuitems[] = ['label' => 'Create Profile', 'url' =>['/profile']]
                $menuItems[] = [
                    'label' => 'Logut (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']                    
                ];
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
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; TMA-AUTOMATICS <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
