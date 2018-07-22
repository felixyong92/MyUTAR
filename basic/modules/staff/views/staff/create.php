<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\staff */

$this->title = 'Register New Staff Account';
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bus-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
