<div  style="width:500px; margin:0 auto" class="form">
    
    <div class="website-info">
        <h1><?php echo t('Reset Password'); ?></h1>
    </div>
    <?php $this->render('cmswidgets.views.notification_frontend'); ?>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
       'id'=>'resetpassword-content',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),     
	        )); 
    ?>
 
    <p style="font:13px Helvetica Neue, Helvetica, Arial, sans-serif; padding-top: 10px">Type your new password to reset.                             
                    </p>
    <div class="textInput" id="inputFirst">            
        <label for="email" class="labelBlur" style="display: inline; ">New Password</label>
        <?php echo $form->textField($model,'password',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'password'); ?>   
    </div>        
  
    <div class="textInput">
         <?php echo CHtml::submitButton(t('Reset Password'),array('class'=>'button-glossy green','id'=>'bReset','style'=>'width:200px!important;')); ?>    
    </div>
    
    <?php $this->endWidget(); ?>
      <script type="text/javascript">     
        
        $(".userform").each(function(){
            if(($(this)).attr('value')!=''){             
                $(this).prev().attr('style','display:none;');
            }
        });
       $('.userform').bind('blur',function(){                               
         if(($(this)).attr('value')==''){             
                $(this).prev().attr('style','display:inline;');
            } else {
                $(this).prev().attr('style','display:none;');
            }    		
        });
        
        $('.userform').bind('focus',function(){                               
            $(this).prev().attr('style','display:none;'); 		
        }); 
    </script>
   
</div>

