<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
?>
<div class = "row">
   <div class = "col-lg-5">
      <?php $form = ActiveForm::begin(['id' => 'registration-form'],['options'=>['enctype' => 'multipart/form-data']]); ?>
      <?= $form->field($model, 'first_name') ?>
      <?= $form->field($model, 'last_name') ?>
      <?= $form->field($model, 'email_address') ?>
      <?= $form->field($model, 'profile_picture')->fileInput() ?>
      <?= $form->field($model, 'marks') ?>
      
      <?= $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'])->label('Status'); ?>  
      <div class = "form-group">
         <?= Html::submitButton('Submit', ['class' => 'btn btn-primary',
            'name' => 'registration-button']) ?>
      </div>
      <?php ActiveForm::end(); ?>
   </div>
</div>