<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'newslettersubscription-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?><br />
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?><br />
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
      
    <div class="row buttons">
        <?php echo CHtml::submitButton('Subscribe'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->