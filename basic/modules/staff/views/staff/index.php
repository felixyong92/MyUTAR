<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\staff\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-account-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Register New Staff Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'dsName',
            'dsResponsibility',
            [
                'attribute'=>'dId',
                'filter'=> ArrayHelper::map(Staff::find()->all(), 'dId', 'dId')
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
