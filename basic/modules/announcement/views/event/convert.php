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

?>

<div class="event-recover">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    //echo "<pre>";var_dump($keys);echo "</pre>";
    //$values = $values + array(null);
    echo "<pre>";print_r($datas);echo "</pre>";

     ?>
</div>
