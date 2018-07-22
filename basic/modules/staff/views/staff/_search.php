<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\StaffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dsId') ?>

    <?= $form->field($model, 'dsName') ?>

    <?= $form->field($model, 'dsResponsibility') ?>

    <?= $form->field($model, 'dId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
