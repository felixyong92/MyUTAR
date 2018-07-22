<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\announcement\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo '<label class="control-label">Upload Images</label>';?>

   <div class="upload_images_wrapper">

     <?php echo $form->field($model, 'images_Temp[]')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => true,
            'showUpload' => false,
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Image',
        ],
         'options' => [
            'accept' => 'image/*',
            'multiple'=>true
        ]
       
    ])->label(false); ?>

    </div>

    <br>

    <?php echo '<label class="control-label">Upload Attachment</label>';?>
    <?php  echo $form->field($model, 'attachments_Temp[]')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showRemove' => true,
            'showUpload' => false,
            'browseLabel' =>  'Select Attachment',
            'maxFileSize' => 40000,
        ],  
         'options' => [
             'accept' => 'docx/doc/pdf/*',
             'multiple'=>true
        ],

       
    ])->label(false); ?>

  <br/>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Cancel', ['/announcement/notification'], ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
