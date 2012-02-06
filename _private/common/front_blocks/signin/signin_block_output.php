<div class="form-stacked">
    
    <div class="website-info">
        <h1><?php echo t('Đăng nhập'); ?></h1>
    </div>
    <?php $this->render('cmswidgets.views.notification_frontend'); ?>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
       'id'=>'login-content',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),     
        )); 
    ?>
 
    <div class="clearfix">
        
     
        <label for="username" class="labelBlur" style="display: inline; ">Email</label>
       	   <div class="input">
        <?php echo $form->textField($model,'username',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'username'); ?>
        </div>   
    </div>        
     
   <div class="clearfix">
        <label for="password" class="labelBlur" style="display: inline; ">Password</label>
        <div class="input">
        <?php echo $form->passwordField($model,'password',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'password'); ?>
        </div>
    </div>
    <p style="font:13px Helvetica Neue, Helvetica, Arial, sans-serif; padding-top: 5px; padding-left:5px"><a href="<?php echo bu();?>/forgot-password">Quên mật khẩu?</a>                             
                    </p>
    <div class="clearfix">
         <?php echo $form->checkBox($model,'rememberMe',array('style'=>'float:left; margin-right:10px')); ?>
         <label>Nhớ đăng nhập cho lần sau</label>
         <?php echo $form->error($model,'rememberMe'); ?>
    </div>
    <div class="actions">
         <?php echo CHtml::submitButton(t('Sign in'),array('class'=>'btn primary','id'=>'bSigninButton')); ?>
    
    </div>
    
    <p style="font:19px Helvetica Neue, Helvetica, Arial, sans-serif; padding-top: 10px">Chưa có tài khoản? 
                            <a href="<?php echo FRONT_SITE_URL;;?>/sign-up">Đăng ký tại đây</a>.
                    </p>
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

