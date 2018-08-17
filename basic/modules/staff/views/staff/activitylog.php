<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\staff\models\Staff;
use asinfotrack\yii2\audittrail\widgets\AuditTrail;
use asinfotrack\yii2\audittrail\models\AuditTrailEntry;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Activity Log';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="activitylog">

    <h1><?= Html::encode($this->title) ?></h1>


<?= /*GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'model_type',
        'happened_at',
        'foreign_pk',
        'user_id',
        'type',
        'data',
    ],
]);*/

 AuditTrail::widget([
	'model'=>$model,

	// some of the optional configurations
	'userIdCallback'=>function ($userId, $dataProvider) {
 		return Staff::findOne($userId)->fullname;
	},
	'changeTypeCallback'=>function ($type, $dataProvider) {
		return Html::tag('span', strtoupper($type), ['class'=>'label label-info']);
	},
	'dataTableOptions'=>['class'=>'table table-condensed table-bordered'],
])
?>


</div>
