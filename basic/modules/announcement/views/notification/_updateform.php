<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
// use app\assets\AppAsset;
// AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\announcement\models\Safety */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJS("$( document ).ready(function() {

            $('.delete-img-butt').click(function() {
                console.log('aaa');
            
                var old_images = $('#old_image_value').attr('value');
                old_images = old_images.split('-');
                var removed_img = $(this).attr('name');
                old_images = jQuery.grep(old_images, function(value) {
                  return value != removed_img;
                });
                old_images = old_images.join('-');

                $('#old_image_value').attr('value', old_images);

                $(this).parent('.imageWrapper').remove();
            });


         $('.delete-att-butt').click(function() {
            
            var old_att = $('#old_att_value').attr('value');
          
            old_att = old_att.split('-');
            
            var removed_att = $(this).attr('name');

            old_att = jQuery.grep(old_att, function(value) {
              return value != removed_att;
            });

            old_att = old_att.join('-');

            $('#old_att_value').attr('value', old_att);
            
            $(this).parent('.attWrapper').remove();
        });
    });");
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' =>20]) ?>

     <?php echo '<label class="control-label">Upload Images</label>'; ?>

     <div class="upload_images_wrapper">

     <div class="old_image_wrapepr">
        
        <?php $old_image_value = []; 
        if($images){
            $count = 0;
            
            foreach ($images as $image) { ?>
                <?php echo '<div class="imageWrapper" id="image_wrapper_'.$count.'"><img src="uploads/images/'.$image.'" height="250px" alt="" name="image_'.$count.'">';
                ?>
                <br/>
                <?php echo '<button style="margin-top:5px;" type="button" class="btn btn-danger delete-img-butt" name = "'.$count.'"><img src="arrow_up.png" height="20px" width="20px"><span>Delete</span></button><br/><br/></div>';
                array_push($old_image_value, $count);
                $count++; 
                ?>



            <?php }

            $old_image_value_implode = implode("-", $old_image_value);

        }

        ?> 

        <?php if($old_image_value) echo'<input type="text" id="old_image_value" name="old_image_value" value ='.$old_image_value_implode.' style="display:none;">';
        else{
            echo'<input type="text" id="old_image_value" name="old_image_value" style="display:none;">';
        }
        ?>

     </div>

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

    <br>


     <?php echo '<label class="control-label">Upload Attachment</label>';?>
    <div class="old_att_wrapepr">
        
        <?php $old_att_value = [];
        if($attachments){
            $count = 0;
            
            foreach ($attachments as $attachment) { ?>
                <?php 
                echo '<div class="attWrapper" id="att_wrapper_'.$count.'"><button style="margin-top:5px;" type="button" class="btn btn-danger delete-att-butt" name = "'.$count.'"><span>Delete</span></button>';
                echo '<a href="uploads/attachments/'.$attachment.'" height="250px" style ="margin-left:10px;" alt="" name="att_'.$count.'">'.$attachment.'</a></div><br/>';
                ?>
                <?php 
                array_push($old_att_value, $count);
                $count++; 
                ?>



            <?php }

            $old_att_value_implode = implode("-", $old_att_value);

        }

        ?> 

        <?php if($old_att_value) echo'<input type="text" id="old_att_value" name="old_att_value" value ='.$old_att_value_implode.' style="display:none;">';
        else{
            echo'<input type="text" id="old_att_value" name="old_att_value" style="display:none;">';
        }
        ?>
     </div>


     
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
		<?= Html::a('Cancel', ['view', 'id' => $model->id], ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
