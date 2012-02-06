<div class="form">
<?php $this->renderPartial('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'color-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row  ">
		<?php echo $form->labelEx($model,'colorname'); ?>
		<?php echo $form->textField($model,'colorname',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'colorname'); ?>
		
	</div>

	<div class="row  ">
		<?php echo $form->labelEx($model,'H'); ?>
		<?php echo $form->textField($model,'H'); ?>
		<?php echo $form->error($model,'H'); ?>
		
	</div>

	<div class="row  ">
		<?php echo $form->labelEx($model,'S'); ?>
		<?php echo $form->textField($model,'S'); ?>
		<?php echo $form->error($model,'S'); ?>
		
	</div>

	<div class="row  ">
		<?php echo $form->labelEx($model,'L'); ?>
		<?php echo $form->textField($model,'L'); ?>
		<?php echo $form->error($model,'L'); ?>
		
	</div>

	<div class="row ">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->