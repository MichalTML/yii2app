<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;



/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="<?php \Yii::getAlias('@web') ?>/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php \Yii::getAlias('@web') ?>/images/favicon.ico" type="image/x-icon" />
    <script src="<?php \Yii::getAlias('@web') ?>/js/jquery.min.js"></script>
    <script src="<?php \Yii::getAlias('@web') ?>/js/fileinput.min.js" type="text/javascript"></script>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody();?>

</html>

