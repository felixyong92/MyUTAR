<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\announcement\models\Notification;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Backup Event';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-bulkmanage">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $status_array = [
        0 => 'Active',
        1 => 'Archived'
    ];
   ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'publishDate',
            'search date'=>'expiryDate',
            [
                'attribute'=>'dId',
                'filter'=> Yii::$app->user->identity->dsResponsibility == 'Super Admin' ? ArrayHelper::map(Notification::find()->all(), 'dId', 'dId') : ''
            ],
            ['class' => 'yii\grid\ActionColumn',
          'template'=> '{view}',
        ],
            ['class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                return ['value' => $data->id];
            },
          ],
        ],
    ]); ?>
    <input type="button" class="btn btn-info" value="Multiple Delete" id="Multiple Delete" >
    <input type="button" class="btn btn-info" value="Multiple Archive" id="Multiple Archive" >
</div>
