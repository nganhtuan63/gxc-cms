<div class="form-stacked" align="left">
    <div class="website-info">
        <h1><?php echo t('Đăng ký thành viên'); ?></h1>
    </div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'userregister-form',
         'enableClientValidation'=>true,
            'clientOptions'=>array(
                    'validateOnSubmit'=>true,
            ),   
        )); 
    ?>

    <div class="clearfix">
      	<label for="user_full_name" class="labelBlur">Họ tên</label>
        <div class="input">
        <?php echo $form->textField($model,'display_name',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'display_name'); ?>
        </div>      
    </div>
        
    <div class="clearfix">
      <label for="user_email" class="labelBlur">Email</label>
       <div class="input">
        <?php echo $form->textField($model,'email',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'email'); ?>
       </div>
    </div>
    
    <div class="clearfix">
      <label for="user_password" class="labelBlur" style="display: inline; ">Password</label>
          <div class="input">
        <?php echo $form->passwordField($model,'password',array('size'=>30,'class'=>'userform','autoComplete'=>'off')); ?>
        <?php echo $form->error($model,'password'); ?>
        </div>
    </div>
    <div class="actions">
    	<p>
    Bằng việc click vào nút "Đăng ký" bạn cũng đồng thời chấp thuận các điều khoản trong
                        <a href="<?php echo FRONT_SITE_URL;?>/terms" onclick="window.open(this.href);return false;">Quy định sử dụng</a>.
                </p>
         <?php echo CHtml::submitButton(t('Đăng ký'),array('class'=>'btn primary','id'=>'bCreateButton')); ?>
        
    
    </div>
    
    <p style="font:19px Helvetica Neue, Helvetica, Arial, sans-serif; padding-top: 10px">Đã đăng ký? 
                            <a href="<?php echo FRONT_SITE_URL;?>/sign-in">Đăng nhập tại đây</a>.
                    </p>
    <?php $this->endWidget(); ?>
   
</div>

