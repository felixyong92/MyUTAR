<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\modules\announcement\models\Notification;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifcation Data Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notification-recover">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="notification-form">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
      <?php  echo $form->field($model, 'file')->widget(FileInput::classname(), [
          'pluginOptions' => [
              'showRemove' => true,
              'showUpload' => false,
              'browseLabel' =>  'Select XML Files',
          ],
          'options' => [
              'accept' => 'xml/*',
              'multiple'=>true
         ],


      ])->label(false); ?>
      <?=Html::submitButton('Submit', ['class' => 'btn btn-info',]);?>
      <?php ActiveForm::end() ?>

      </div>
</div>
