<?php $action=$model->getIsNewRecord() ? 'Create' : 'Update';?>
<?php Yii::app()->controller->pageTitle = TranslateModule::t(($action) . ' Message')." # ".$model->id." - ".TranslateModule::translator()->acceptedLanguages[$model->language]; ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
        
)); ?>

<div class="form">	
    
    <?php echo $form->hiddenField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
    <?php echo $form->hiddenField($model,'language',array('size'=>16,'maxlength'=>16)); ?>
    
    <div class="row">
        <?php echo $form->label($model->source,'category'); ?>
        <?php echo $form->textField($model->source,'category',array('disabled'=>'disabled')); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model->source,'message'); ?>
        <?php echo $form->textField($model->source,'message',array('disabled'=>'disabled')); ?>
    </div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'translation'); ?>
		<?php echo $form->textArea($model,'translation',array('rows'=>2, 'cols'=>80)); ?>
		<?php echo $form->error($model,'translation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(TranslateModule::t($action)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<!-- form -->