<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uEmail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uPassword')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
