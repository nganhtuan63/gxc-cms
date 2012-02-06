<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'userupdate-form',
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
<div class="row">
        <?php echo $form->labelEx($model,'user_url'); ?>
        <?php echo $form->textField($model,'user_url'); ?>
        <?php echo $form->error($model,'user_url'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
</div>
    
<div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',ConstantDefine::getUserStatus()); ?>
        <?php echo $form->error($model,'status'); ?>                                  
</div>

<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->