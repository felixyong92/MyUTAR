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


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        ['label' => 'Model Affected',
       'attribute' => 'model_type',
       ],
        'timestamp',
        ['label' => 'User',
       'attribute' => 'user_id',
       ],
        ['label' => 'Action',
       'attribute' => 'type',
       ],
        'data',
    ],
]);
?>


</div>
