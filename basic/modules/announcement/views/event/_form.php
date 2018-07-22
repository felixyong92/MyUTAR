<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\announcement\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'venue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(($model->types),
        ['prompt' => "Please choose the event's type"])->label('Type') ?>

    <?= $form->field($model, 'description')->textarea(['rows' =>20]) ?>

    <?php echo '<label class="control-label">Upload Images</label>'; ?>

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
    <p><font color = "red">*Hold <strong>CTRL</strong> to select multiple images*</font></p>
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
    <p><font color ="red">*Hold <strong>CTRL</strong> to select multiple attachments*</font></p>

  <br/>

   <?php

    echo $form->field($model, 'expiryDate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Expiry Date'],
        'name' => 'expiryDate',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ])
   ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Cancel', ['/announcement/event'], ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
