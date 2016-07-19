<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>

    <?php $this->head() ?>

    <script src="https://use.fontawesome.com/996ada9d76.js"></script>

    <title><?= Html::encode($this->title) ?></title>

    <link rel="icon" type="image/x-icon" href="/src/favicon.ico"/>
    <script type="text/javascript">
        if (window.location.hash == '#_=_'){
            // Check if the browser supports history.replaceState.
            if (history.replaceState) {
                // Keep the exact URL up to the hash.
                var cleanHref = window.location.href.split('#')[0];
                // Replace the URL in the address bar without messing with the back button.
                history.replaceState(null, null, cleanHref);
            } else {
                // Well, you're on an old browser, we can get rid of the _=_ but not the #.
                window.location.hash = '';
            }
        }
    </script>

</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render("header"); ?>

<?= $this->render("pageHead"); ?>


<!-- Page content -->
<div class="row page-content">
    <div class="container">

        <?= $this->render("authentication"); ?>

        <?= $this->render("comment"); ?>

        <?= $this->render("formEmailEnter"); ?>

        <?php if (isset($this->params['activeTags'])): ?>

            <?= $this->render("leftBlock", ['activeTags' => $this->params['activeTags']]); ?>

        <?php else: ?>

            <?= $this->render("adminLeftBlock"); ?>

        <?php endif; ?>

        <?= $content ?>

    </div>
</div>
<!-- /Page content -->

<?= $this->render("footer"); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

