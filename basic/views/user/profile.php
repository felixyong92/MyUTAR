<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\staff */

$this->title = 'Profile Information';
$this->params['breadcrumbs'][] = 'Profile';
?>
<div class="staff-account-view">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dsId',
            'dsName',
            'dsEmail',
            'dsRole',
            'dId',
        ],
    ]) ?>
</div>
