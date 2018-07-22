<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DepartmentStaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Department Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Department Staff', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dsId',
            'dsName',
            'dsEmail:email',
            'dsPassword',
            'dId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
