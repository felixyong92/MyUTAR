<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\Staff */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Change Password';
?>
<div class="bus-service-update">

    <h1><?= Html::encode($this->title) ?></h1>

  	<?= $this->render('_changePasswordForm', [
        'model' => $model,
    ]) ?>

</div>
