<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-content',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
    
<div class="notification noteinformation png_bg">
<div>
<?php echo t('Please fill in your Username and Password'); ?>
    
    <?php if (user()->isGuest) echo 'Guest'; else echo 'Member' ; ?>
</div>
</div>
					
<div>
        <?php echo $form->error($model,'username',array('style'=>'text-align:right')); ?>
        <?php echo $form->label($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('class'=>'text-input')); ?>
</div>
<div class="clear"></div>
<div>
        <?php echo $form->error($model,'password',array('style'=>'text-align:right')); ?>
        <?php echo $form->label($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('class'=>'text-input')); ?>
</div>
<div class="clear"></div>
<div id="remember-password" style="float:right;">
        <?php echo $form->checkBox($model,'rememberMe',array('style'=>'float:left;margin-right: 5px;')); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
</div>
<div class="clear"></div>
<div>
    <?php echo CHtml::submitButton(t('Login'),array('id'=>'login-content-button','class'=>'bebutton')); ?>
    
</div>
<br class="clear" />
					


<?php $this->endWidget(); ?>
</div><!-- form -->
