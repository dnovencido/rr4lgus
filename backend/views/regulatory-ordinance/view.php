<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Regulatory Reform Technical Report';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => 'Preview' ];
\yii\web\YiiAsset::register($this);
?>
<div class="regulatory-ordinance-view">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2><?= Html::encode($this->title) ?></h2>
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>            
        </div>
        <div class="card-body">
            <table class="table table-bordered regulatory-reform-tech-report">
                <thead>
                    <tr>
                        <th scope="row" colspan="3" class="table-label"><center>LGU Information</center></th>
                    </tr>       
                </thead>
                <tbody>
                    <tr>
                        <td scope="row" class="col-2 table-label">Name</td>
                        <td class="table-desc"><?= $model->lguName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Department/Office</td>
                        <td class="table-desc"><?= $model->officeName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Date of Submission</td>
                        <td class="table-desc"><?= $model->dateSub ?></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><center>List of governing ordinance(s) that need to be repealed, amended, consolidated<center></td>
                    </tr>  
                    <tr>
                        <td scope="row" class="table-label">Ordinance/Resolution Number</td>
                        <td scope="row" class="table-label"><center>Ordinance/Resolution Title</center></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-desc"><center><?= $model->ordinanceResNo ?></center></td>
                        <td scope="row" rowspan="3" class="table-desc"><?= $model->ordinanceTitle ?></td>
                    </tr>      
                    <tr>
                        <td scope="row" class="table-label">Date of effectivity/passage</td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-desc"><center><?= $model->effDatePass ?></center></td>
                    </tr>   
                    <tr>
                        <td scope="row" colspan="3" class="table-label">Brief description og the Ordinance/Resolution</td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="3" class="table-desc"><?= $model->ordinanceDesc ?></td>
                    </tr>  
                    <tr>
                        <td scope="row" colspan="3" class="table-label">List of agency-level issuance(s) it affect</td>
                    </tr>
                    <tr>    
                        <td scope="row" class="table-label"><center>Code</center></td>
                        <td scope="row" class="table-label"><center>Title</center></td>
                    </tr>
                    <tr>
                        <?php
                            foreach($model->agencyAffectedLevelEntry as $row) {
                                echo "<td scope='row'class='table-desc'><center>".$row['code']."</center></td><td scope='row' class='table-desc'>".$row['title']."</td>";
                            }
                        ?>
                    </tr>            
                    <tr>
                        <td scope="row" colspan="3" class="table-label">Rationale behind recommended policy option</td>
                    <tr>  
                    <tr>
                        <td scope="row" colspan="3" class="table-desc"><?= $model->rationale ?></td>
                    </tr>                                                                           
                </tbody>
            </table> <!-- /.table table-bordered -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>
