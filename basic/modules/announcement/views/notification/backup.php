<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\announcement\models\Notification;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Backup Notification';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-backup">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=Html::beginForm(['notification/backupall'],'post');?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'publishDate',
            [
                'attribute'=>'dId',
                'filter'=> Yii::$app->user->identity->dsResponsibility == 'Super Admin' ? ArrayHelper::map(Notification::find()->all(), 'dId', 'dId') : ''
            ],
            ['class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                return ['value' => $data->id];
            },
      ],
        ],
    ]); ?>
    <?=Html::submitButton('Backup', ['class' => 'btn btn-info',]);?>
    <?= Html::endForm();?>

</div>
