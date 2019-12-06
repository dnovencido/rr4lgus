<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */
if (Yii::$app->controller->action->id === 'register') { 
    echo $this->render(
        'registration',
        ['content' => $content]
    );
    
} else if(Yii::$app->controller->action->id === 'resend') {
    echo $this->render(
        'resend',
        ['content' => $content]
    );
    
} else if(Yii::$app->controller->action->id === 'login') {
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
   
} else {
    
    frontend\assets\AppAsset::register($this);

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
    <div class="mobile-sticky-body-overlay"></div>
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'left.php'
        )?>
        
        <div class="page-wrapper">
            <?= $this->render(
                'header.php'
            )?>            
            <?= $this->render(
                'content.php', ['content' =>  $content ]
            )?>
        </div>
        
    </div>

    <?php $this->endBody() ?>

    </body>
    </html>

<!-- External script -->
<?php

$options = [
    'appName' => Yii::$app->name,
    'baseUrl' => Yii::$app->request->baseUrl,
    'language' => Yii::$app->language,
];

$this->registerJs(
    "var yiiOptions = ".\yii\helpers\Json::htmlEncode($options).";",
    View::POS_HEAD,
    'yiiOptions'
);

$script = <<< JS
    $(function(){
        var dashboard = new Dashboard();
    });
JS;

$this->registerJs($script);

?> 
        
<?php $this->endPage() ?>
<?php } ?>
