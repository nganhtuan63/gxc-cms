<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'author_name'); ?><br />
        <?php echo $form->textField($model,'author_name',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'author_name'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?><br />
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'topic'); ?><br />
        <?php echo $form->textField($model,'topic',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'topic'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'content'); ?><br />
        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>
    <?php if(extension_loaded('gd')): ?>
    <div class="row">
    	<?php echo $form->labelEx($model,'verifyCode'); ?><br />
        <?php echo $form->textField($model,'verifyCode'); ?><br />
    	<?php $this->widget('CCaptcha'); ?>
    </div>
    <?php endif;?>
  
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Summit' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->