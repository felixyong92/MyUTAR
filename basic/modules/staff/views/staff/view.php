<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\staff */

$this->title = 'Staff Information';
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->dsName;
?>
<div class="staff-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dsId], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Change Password', ['changepassword', 'id' => $model->dsId], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dsId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this account?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dsId',
            'dsName',
            'dsEmail',
            'dsResponsibility',
            'dId',
        ],
    ]) ?>
</div>
