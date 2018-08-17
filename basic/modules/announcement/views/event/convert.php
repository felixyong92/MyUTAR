<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\modules\announcement\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recovery Status';
$this->params['breadcrumbs'][] = $this->title;
  echo "<pre>";print_r($configData);echo "</pre>";
?>

<div class="event-recover">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="event-form">

      </div>
</div>
