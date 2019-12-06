<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use kartik\growl\Growl;


AppAsset::register($this);
?>

<div class="content-wrapper">
    <div class="content">
        <nav aria-label="breadcrumb">	
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li class='breadcrumb-item'><i>{link}</i></li>\n", 
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumb breadcrumb-inverse'],
            ]);?>
        </nav>
            <!-- Flash messages -->
            <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                <?= Growl::widget([
                    'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                    'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                    'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                    'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                    'showSeparator' => true,
                    'delay' => 1, //This delay is how long before the message shows
                    'pluginOptions' => [
                        'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                        'placement' => [
                            'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                            'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                        ]
                    ]
                ]);
                ?>
            <?php endforeach; ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
        © <span id="copy-year">2019</span> DILG - ARTA RRIS
        </p>
    </div>
</footer>

