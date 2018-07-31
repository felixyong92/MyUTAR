<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\announcement\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Backup Event';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-backup">

    <h1><?= Html::encode($this->title) ?></h1>

   <?=Html::beginForm(['event/backupall'],'post');?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'endDate',
            [
                'attribute'=>'dId',
                'filter'=> Yii::$app->user->identity->dsResponsibility == 'Super Admin' ? ArrayHelper::map(Event::find()->all(), 'dId', 'dId') : ''
            ],
            ['class' => 'yii\grid\CheckboxColumn',
          ],
        ],
    ]); ?>
    <?=Html::submitButton('Backup', ['class' => 'btn btn-info',]);?>
    <?= Html::endForm();?>

</div>
