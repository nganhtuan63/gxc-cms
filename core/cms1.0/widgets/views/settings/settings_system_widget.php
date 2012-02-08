<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'settings-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model,'support_email'); ?>
        <?php echo $form->textField($model,'support_email'); ?>
        <?php echo $form->error($model,'support_email'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'page_size'); ?>
        <?php echo $form->textField($model,'page_size'); ?>
        <?php echo $form->error($model,'page_size'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'language_number'); ?>
        <?php echo $form->textField($model,'language_number'); ?>
        <?php echo $form->error($model,'language_number'); ?>
</div>
    
 
<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
