<?php

use app\models\Department;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\ */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-changePassword">
 
    <?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'oldpassword')->passwordInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
 
        <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>
		<?= Yii::$app->session->getFlash('success') ?>
    <?php ActiveForm::end(); ?>
 
</div>
