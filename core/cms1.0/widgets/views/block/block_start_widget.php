<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'block-start-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',  GxcHelpers::getAvailableBlocks(true),
                    array('options' => array($type=>array('selected'=>true)))); ?>			
                <?php echo $form->error($model,'type'); ?>
        <div class="clear"></div> 
	</div>
        <script>
            function nextSlotStep(){
                window.location = document.URL+"/type/"+$('#Block_type').val();
            }
        </script>
	
	<div class="row">
            <?php echo CHtml::Button('Next', array('class'=>'button','onclick'=>'return nextSlotStep();')); ?>
            
                
        <?php if(isset($_GET['embed'])): ?>
        <input type="button" class="button" value="<?php echo t('Cancel');?>" onClick="window.parent.cancelOnAddBlock(window.parent.document.getElementById(window.name));"/>
        <?php endif; ?>
            <div class="clear"></div>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
