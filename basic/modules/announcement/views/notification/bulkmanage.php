<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\announcement\models\Notification;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bulk Manage Notification';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-bulkmanage">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $status_array = [
        0 => 'Active',
        1 => 'Archived'
    ];
   ?>
   <?=Html::beginForm(['notification/bulk'],'post');?>
   <?=Html::dropDownList('action','',[''=>'Choose an action: ','d'=>'Delete','a'=>'Archive'],['class'=>'dropdown',])?>
   <?=Html::submitButton('Apply', ['class' => 'btn btn-info',]);?>
     <?= GridView::widget([
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'columns' => [
             ['class' => 'yii\grid\SerialColumn'],
             'title',
             'publishDate',
             ['label' => 'Status',
            'value' => function($model){
                return $model->statusText;},
            'attribute' => 'status',
            'filter' =>  $status_array,
            ],
             [
                 'attribute'=>'dId',
                 'filter'=> Yii::$app->user->identity->dsResponsibility == 'Super Admin' ? ArrayHelper::map(Notification::find()->all(), 'dId', 'dId') : ''
             ],
             ['class' => 'yii\grid\ActionColumn',
           'template'=> '{view}',
         ],
             ['class' => 'yii\grid\CheckboxColumn',
           ],
         ],
     ]); ?>
     <?= Html::endForm();?>


</div>
