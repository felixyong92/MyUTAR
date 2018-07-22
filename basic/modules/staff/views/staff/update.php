<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\Staff */

$this->title = 'Staff Information: ' . $model->dsName;
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dsName, 'url' => ['view', 'id' => $model->dsId]];
$this->params['breadcrumbs'][] = 'Edit Staff Information';
?>
<div class="bus-service-update">

    <h1><?= Html::encode($this->title) ?></h1>

  	<?= $this->render('_updateform', [
        'model' => $model,
    ]) ?>

</div>
