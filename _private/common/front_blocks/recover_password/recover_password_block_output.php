<div class="form-stacked">
    
    <div class="website-info">
        <h1><?php echo t('Quên mật khẩu?'); ?></h1>
    </div>
    <?php $this->render('cmswidgets.views.notification_frontend'); ?>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
       'id'=>'recoverpassword-content',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),     
	        )); 
    ?>
 
    <p style="font:13px Helvetica Neue, Helvetica, Arial, sans-serif; padding-top: 10px">Hãy nhập email bạn sử dụng dưới đây và hệ thống sẽ gởi bạn hướng dẫn khôi phục mật khẩu. 
                            
	</p>
      <div class="clearfix">
            
        <label for="email" class="labelBlur" style="display: inline; ">Email</label>
 		<div class="input">       
        <?php echo $form->textField($model,'email',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'email'); ?>
        </div>   
    </div>        
  
    <div class="actions">
         <?php echo CHtml::submitButton(t('Khôi phục mật khẩu'),array('class'=>'btn primary','id'=>'bReset')); ?>    
    </div>
    
    <?php $this->endWidget(); ?>
     
   
</div>

