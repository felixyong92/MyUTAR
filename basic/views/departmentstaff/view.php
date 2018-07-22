<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DepartmentStaff */

$this->title = $model->dsId;
$this->params['breadcrumbs'][] = ['label' => 'Department Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-staff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dsId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dsId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dsId',
            'dsName',
            'dsEmail:email',
            'dsPassword',
            'dId',
        ],
    ]) ?>

</div>
