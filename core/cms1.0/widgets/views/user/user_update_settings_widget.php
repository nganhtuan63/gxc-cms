<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'userupdatesettings-form',
        'enableAjaxValidation'=>true,       
        )); 
?>


<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model,'display_name'); ?>
        <?php echo $form->textField($model,'display_name'); ?>
        <?php echo $form->error($model,'display_name'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
</div>

<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->