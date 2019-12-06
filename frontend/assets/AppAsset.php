<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css',
        // 'plugins/toaster/toastr.min.css',
        // 'plugins/nprogress/nprogress.css',
        // 'plugins/flag-icons/css/flag-icon.min.css',
        // 'plugins/jvectormap/jquery-jvectormap-2.0.3.css',
        // 'plugins/ladda/ladda.min.css',
        'css/micromodal/micromodal.css',
        'css/sleek/sleek.css',
        'css/site.css'
    ];
    public $js = [
        // 'plugins/nprogress/nprogress.js',
        // 'plugins/toaster/toastr.min.js',
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'plugins/jquery-mask-input/jquery.mask.min.js',
        'js/moment/moment.js',
        'plugins/slimscrollbar/jquery.slimscroll.min.js',
        // 'plugins/charts/Chart.min.js',
        // 'plugins/ladda/spin.min.js',
        // 'plugins/ladda/ladda.min.js',
        // 'plugins/jvectormap/jquery-jvectormap-2.0.3.min.js',
        // 'plugins/jvectormap/jquery-jvectormap-world-mill.js',
        // 'plugins/jekyll-search.min.js',
        'js/micromodal/micromodal.min.js',
        'js/sleek/sleek.js',
        // 'js/chart.js',
        // 'js/map.js',
        // 'js/custom.js',
        'js/Dashboard.js',
        'js/Events.js',
        'js/Render.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
