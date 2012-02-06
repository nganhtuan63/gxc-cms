<div class="form-stacked">
  
        <?php $this->render('cmswidgets.views.notification_frontend'); ?>
      
    
         <h3 style="border-bottom:1px dotted #CCC; margin-bottom:10px"><?php echo t('Mật khẩu'); ?></h3>
        
    
        <?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'changepass-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),     
            )); 
        ?>
     
        <div  class="clearfix">
              <?php echo $form->label($model,'old_password'); ?>
              <?php echo $form->passwordField($model,'old_password',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'old_password',array('style'=>'width: 540px;margin-left: 170px;')); ?>
        </div>
        <div  class="clearfix">
              <?php echo $form->label($model,'new_password_1'); ?>
              <?php echo $form->passwordField($model,'new_password_1',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'new_password_1',array('style'=>'width: 540px;margin-left: 170px;')); ?>
        </div>
      <div  class="clearfix">
              <?php echo $form->label($model,'new_password_2'); ?>
              <?php echo $form->passwordField($model,'new_password_2',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'new_password_2',array('style'=>'width: 540px;margin-left: 170px;')); ?>
        </div>
        
       
        <div class="actions" >
        <?php echo CHtml::submitButton(t('Thay đổi mật khẩu'),array('class'=>'btn','id'=>'bChangePassword')); ?>

        </div>
         <?php $this->endWidget(); ?>
         
          <h3 style="border-bottom:1px dotted #CCC; margin-bottom:10px"><?php echo t('Thông báo'); ?></h3>
          <?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'notify-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),     
            )); 
        ?>
        <div  class="clearfix">
        <strong ><?php echo t('Cho phép gởi thông báo cho tôi khi')?></strong>
       </div>
        <div  class="clearfix">
         	<?php echo $form->checkBox($model_notify,'email_site_news',array('style'=>'float:left;width:20px;')); ?>
            <label style="width:50%;text-align:left; margin-top:0px"><?php echo t('Khi HocMoiNgay.com có những thay đổi, sự kiện lớn.');?></label>
            <?php echo $form->error($model_notify,'email_site_news'); ?>
            <div class="clear"></div>
    	</div>
    	<div  class="clearfix">
         	<?php echo $form->checkBox($model_notify,'email_search_alert',array('style'=>'float:left;width:20px;')); ?>
            <label style="width:50%;text-align:left; margin-top:0px"><?php echo t('Khi có những bài học phù hợp với mối quan tâm của tôi.');?></label>
            <?php echo $form->error($model_notify,'email_search_alert'); ?>
            <div class="clear"></div>
    	</div>
    	 <div class="actions">
        <?php echo CHtml::submitButton(t('Cập nhật'),array('class'=>'btn','id'=>'bUpdateNotify')); ?>

        </div>
    	<?php $this->endWidget(); ?>
    </div>
    
