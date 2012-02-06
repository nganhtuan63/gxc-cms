<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'settings-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model,'site_name'); ?>
        <?php echo $form->textField($model,'site_name'); ?>
        <?php echo $form->error($model,'site_name'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'site_title'); ?>
        <?php echo $form->textField($model,'site_title'); ?>
        <?php echo $form->error($model,'site_title'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'site_description'); ?>
        <?php echo $form->textField($model,'site_description'); ?>
        <?php echo $form->error($model,'site_description'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'homepage'); ?>
        <?php echo $form->textField($model,'homepage'); ?>
        <?php echo $form->error($model,'homepage'); ?>
</div>
<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
