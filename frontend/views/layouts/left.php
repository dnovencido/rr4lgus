<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="/index.html">
            <svg
                class="brand-icon"
                xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="xMidYMid"
                width="30"
                height="33"
                viewBox="0 0 30 33"
            >
                <g fill="none" fill-rule="evenodd">
                <path
                    class="logo-fill-blue"
                    fill="#7DBCFF"
                    d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                />
                <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                </g>
            </svg>
            <span class="brand-name"><?= Yii::$app->name ?></span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
            
                <li class="active" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
                        aria-expanded="false" aria-controls="dashboard">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li >
                    <?= Html::a('<i class="mdi mdi-library-books"></i><span class="nav-text">Stocktaking Tool</span>', ['/regulatory-map'], ['class'=>'sidenav-item-link']) ?>
                </li>                
                <li class="has-sub expand">
                    <?= Html::a('<i class="mdi mdi-clipboard-outline"></i><span class="nav-text">Regulatory Reforms <br> Technical Reports </span>', ['#'], ['class'=>'sidenav-item-link', 'data-toggle' => 'collapse', 'data-target' => '#regulatory-reform-reports',  'data-expanded' => 'false', 'data-controls' =>'regulatory-reform-reports']) ?>
                </li>
                <ul class="collapse" id="regulatory-reform-reports" data-parent="#sidebar-menu">
                    <div class="sub-menu">
                        <li >
                            <?= Html::a('<i class="mdi mdi-clipboard-outline"></i><span class="nav-text"> ORDINANCES</span>', ['/regulatory-ordinance'], ['class'=>'sidenav-item-link']) ?>
                        </li>                      
                        <li >
                            <?= Html::a('<i class="mdi mdi-clipboard-outline"></i><span class="nav-text"> ISSUANCES</span>', ['/regulatory-issuance'], ['class'=>'sidenav-item-link']) ?>
                        </li>                            
                    </div>
                </ul> 
                <li >
                    <?= Html::a('<i class="mdi mdi-library-books"></i><span class="nav-text"> Submitted Reports </span>', ['/report/submitted'], ['class'=>'sidenav-item-link']) ?>
                </li>                                 
            </ul> <!-- /.nav -->

        <hr class="separator" />

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
            </div>
        </div>
    </div>
</aside>