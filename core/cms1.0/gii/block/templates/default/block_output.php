<div class="form-stacked">
  
        <?php echo "<?php"; ?> $this->render('cmswidgets.views.notification_frontend'); ?>

        <?php echo "<?php"; ?> $form=$this->beginWidget('CActiveForm', array(
           'id'=>'<?php echo strtolower($this->getBlockClass($this->blockName)); ?>-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),     
            )); 
        ?>
 		<!-- Uncomment to place customized zones-->    
        <!-- <div  class="clearfix">
             
        </div> -->
         <?php echo "<?php"; ?> $this->endWidget(); ?>
</div>