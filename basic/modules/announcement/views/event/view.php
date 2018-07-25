<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\announcement\models\Event */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    <?php
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentDate = date("Y-m-d");
        if($currentDate > $model->endDate){
    ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }else{ ?>

         <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>
    </p>

     <?php
     $htmlImg = '';
     if($images){
         foreach ($images as $image) {
             $htmlImg.='<img src="uploads/images/'.$image.'" height="250px" alt="">';
         }
     }

    ?>
     <?php
    $htmlAttachment = '';
    if($attachments){

        foreach ($attachments as $attachment) {
            $htmlAttachment.='<a href="uploads/attachments/'.$attachment.'" download>'.$attachment.'</a><br/>';
        }
    }

    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'venue',
            'time',
            'startDate',
            'endDate',
            'fee',
            'type',
            'description:ntext',
            'publishDate',
            ['label' => 'Images',
             'format'=>'raw',
             'value'=>$htmlImg,
             ],
            ['label' => 'Attachments',
             'format'=>'raw',
             'value'=>$htmlAttachment,
             ],
            ['label' => 'Department',
             'value'=> $model->dId,
             ],
             ['label' => 'Status',
            'value' =>$model->expiredText,
            ],
        ],
    ]) ?>



</div>
