<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    /* @var $this \yii\web\View */
    /* @var $content string */
?>

<!-- Header -->
<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
        <span class="sr-only">Toggle navigation</span>
        </button>
        <!-- search form -->
        <div class="search-form d-none d-lg-inline-block">
        <div class="input-group">
            <button type="button" name="search" id="search-btn" class="btn btn-flat">
            <i class="mdi mdi-magnify"></i>
            </button>
            <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
            autofocus autocomplete="off" />
        </div>
        <div id="search-results-container">
            <ul id="search-results"></ul>
        </div>
        </div>

        <div class="navbar-right ">
        <ul class="nav navbar-nav">
            <!-- User Account -->
            <li class="dropdown user-menu">
                <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <img src="assets/img/user/user.png" class="user-image" alt="User Image" />
                    <span class="d-none d-lg-inline-block"><?= Yii::$app->user->identity->firstName ?> </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <!-- User image -->
                    <li class="dropdown-header">
                        <img src="assets/img/user/user.png" class="img-circle" alt="User Image" />
                        <div class="d-inline-block">
                            <?= Yii::$app->user->identity->firstName ?> <small class="pt-1"><?= Yii::$app->user->identity->office ?></small>
                        </div>
                    </li>
                    <li>
                        <a href="#"> <i class="mdi mdi-settings"></i> Account Setting </a>
                    </li>

                    <li class="dropdown-footer">
                        <?= Html::a(
                            '<i class="mdi mdi-logout"></i> Log Out </a>',
                            ['/site/logout'],
                            ['data-method' => 'post']
                        )?>                    
                    </li>

                </ul>
            </li>
        </ul>
        </div>
    </nav>
</header>
