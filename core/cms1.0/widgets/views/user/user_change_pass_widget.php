 <div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'userchangepass-form',
        'enableAjaxValidation'=>true,
        'htmlOptions'=>array("autocomplete"=>"off")
        )); 
?>

<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model,'old_password'); ?>
        <?php echo $form->passwordField($model,'old_password',array("autocomplete"=>"off")); ?>
        <?php echo $form->error($model,'old_password'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'new_password_1'); ?>
        <?php echo $form->passwordField($model,'new_password_1',array("autocomplete"=>"off")); ?>
        <?php echo $form->error($model,'new_password_1'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'new_password_2'); ?>
        <?php echo $form->passwordField($model,'new_password_2',array("autocomplete"=>"off")); ?>
        <?php echo $form->error($model,'new_password_2'); ?>
</div>

<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->