<?php
                    $mycs=Yii::app()->getClientScript();                    
                    if(YII_DEBUG)
                        $ckeditor_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.ckeditor'), false, -1, true);                    
                    else
                        $ckeditor_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.ckeditor'), false, -1, false);                    
                    
                    $urlScript_ckeditor= $ckeditor_asset.'/ckeditor.js';
                    $urlScript_ckeditor_jquery=$ckeditor_asset.'/adapters/jquery.js';
                    $mycs->registerScriptFile($urlScript_ckeditor, CClientScript::POS_HEAD);
                    $mycs->registerScriptFile($urlScript_ckeditor_jquery, CClientScript::POS_HEAD);    
?>

<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'newsletter-form',
        'enableAjaxValidation'=>false,       
        )); 
?>
<?php echo $form->errorSummary($model); ?>
	<div class="form-wrapper">
		<div id="form-body">
            <div id="form-body-content">
            	<div id="titlewrap">
			         <?php echo $form->textField($model,'topic',array('class'=>'specialTitle','tabindex'=>'1','id'=>'txt_topic')); ?>
			         <?php echo $form->error($model,'topic'); ?>									
				</div>
				<div id="small_buttons_insert" align="right">
					<span><?php echo t('Insert'); ?></span>
					<img valign="top" alt="Image" title="Image" onClick="insertFileToContent('image');" src="<?php echo Yii::app()->controller->backend_asset; ?>/images/insert_image.png" />
					<!--<img valign="top" onClick="insertFileToContent('video');" src="<?php echo Yii::app()->controller->backend_asset; ?>/images/insert_video.png" />-->		
				</div>
				<div id="bodywrap">		
			         <?php echo $form->textArea($model,'content',array('tabindex'=>'2','class'=>'specialContent','id'=>'ckeditor_content')); ?>
			         <?php echo $form->error($model,'content'); ?>                                                          
				</div>
				<div id="titlewrap">
					<?php echo $form->hiddenField($model,'status', array('class'=>'specialTitle', 'tabindex'=>'3','id'=>'txt_status'));?>
				</div>
            	<?php echo CHtml::Button(t('Send'),array('style'=>'width:100px;','class'=>'button active', 'onClick'=> 'return send();')); ?>
            	<?php echo CHtml::Button(t('Save to draft'),array('style'=>'width:130px;','class'=>'button active', 'onClick'=>'return save();')); ?>
            	<script type="text/javascript">
            		function save()
            		{
                		$('#txt_status').val(<?php echo ConstantDefine::NEWSLETTER_STATUS_DRAFT; ?>);
                		$('#newsletter-form').submit();
            		}

            		function send()
            		{
            			$('#txt_status').val(<?php echo ConstantDefine::NEWSLETTER_STATUS_SENT; ?>);
                		$('#newsletter-form').submit();
            		}
            	</script>	
            </div>
        </div>
        	
    	
	</div>
<br class="clear" />
<?php $this->endWidget(); ?>
</div>
<!-- //Render Partial for Javascript Stuff -->
<?php $this->render('cmswidgets.views.object.object_form_javascript',array('model'=>$model,'form'=>$form,'type'=>$type)); ?>