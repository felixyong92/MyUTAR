<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DepartmentStaffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-staff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dsId') ?>

    <?= $form->field($model, 'dsName') ?>

    <?= $form->field($model, 'dsEmail') ?>

    <?= $form->field($model, 'dsPassword') ?>

    <?= $form->field($model, 'dId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
