<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\announcement\models\Notification */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
        
        <?php if($model->status==1){ ?>
         <?= Html::a('Unachive', ['unarchive', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to unarchive this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }else {?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Archive', ['archive', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to archive this item?',
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
            ['label' => 'Link',
             'format'=>'raw',
             'value'=>'<a href="'.$model->link.'" target="_blank">'.$model->link.'</a>',
             ],
            ['label' => 'Status',
             'value'=> $model->statusText,
             ],
            ['label' => 'Department',
             'value'=> $model->dId,
             ],
        ],
    ]) ?>

</div>
