<div class="form-stacked" style="padding-left:0px">
  
        <?php $this->render('cmswidgets.views.notification_frontend'); ?>
      
    
    
        <?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'avatar-form',
            
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,                
            ),
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            )); 
        ?>
        <div class="clearfix">
            <?php echo $form->label($model,'image'); ?>
            <img style="float:none; margin-bottom:3px" src="<?php echo GxcHelpers::getUserAvatar('96',user()->getModel()->avatar,$this->layout_asset.'/images/avatar.png');?>" class="avatar profile_photo"/>
            <div class="input"></div>
            <a style="" href="javascript:void(0);" onClick="return removeAvatar();"><?php echo t('Xoá ảnh đại diện'); ?></a>                    
           <?php echo $form->fileField($model,'image',array('style'=>'display:block; margin-top:15px')); ?>
        <?php echo $form->error($model,'image',array('style'=>'width: 540px;')); ?>
        	</div> 
        	
          <?php echo CHtml::submitButton(t('Cập nhật ảnh đại điện'),array('class'=>'btn','id'=>'bUpdateAvatar')); ?>
           
           
           <?php $this->endWidget(); ?>                            
        </div>
        <script type="text/javascript">
        	function removeAvatar(){        		        	
        		if(confirm('Are you sure you want to remove current Avatar?')){                        
        			$.post("<?php echo bu();?>/remove-avatar", { ResetAvatar: "true", YII_CSRF_TOKEN: "<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>"},
					 function(data) {
					   	if(data==1){
					   		window.parent.location.href = "<?php echo FRONT_SITE_URL;?>/profile";
					   	} else {
					   		alert('Error while updating Avatar');
					   	}
					 }		
					);
				}
        	}
        </script>
    
</div>