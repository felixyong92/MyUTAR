<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\modules\announcement\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Data Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="event-recover">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="event-form">

      <?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>


      </div>
</div>
