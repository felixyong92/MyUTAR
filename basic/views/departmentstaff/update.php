<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DepartmentStaff */

$this->title = 'Update Department Staff: ' . $model->dsId;
$this->params['breadcrumbs'][] = ['label' => 'Department Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dsId, 'url' => ['view', 'id' => $model->dsId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="department-staff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
