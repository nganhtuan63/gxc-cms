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
        'id'=>'object-form',
        'enableAjaxValidation'=>false,       
        )); 
?>
<?php echo $form->errorSummary($model); ?>
<div class="form-wrapper">
    <div id="form-sidebar">
            <?php $this->render('cmswidgets.views.object.object_publish_sidebar_form',array('form'=>$form,'model'=>$model,'content_status'=>$content_status,'type'=>$type,'terms'=>$terms,'selected_terms'=>$selected_terms)); ?>
    </div>
    <div id="form-body">
            <div id="form-body-content">
            	
            		<!-- //Render Partial for Object Language Zone & Name & Content-->
                    <?php $this->render('cmswidgets.views.object.object_language_name_content_widget',array('model'=>$model,'type'=>$type,'form'=>$form,'versions'=>$versions,'lang_exclude'=>$lang_exclude)); ?>
  
                    <div class="row">
                    		<!-- //Render Partial for Resource Binding -->
                    		<?php $this->render('cmswidgets.views.object.object_resource_form_widget',array('model'=>$model,'type'=>$type,'content_resources'=>$content_resources)); ?>                    	
                    </div>
                    
                    <div class="row">
                    <!--Start the Meta Box -->
                    <div class="closed-box content-box">
                            <div class="content-box-header">
                            <h3><?php echo t('Content Extra');?></h3>                             
                            </div> 
                            <div class="content-box-content" style="display: block;">

                                    <div class="tab-content default-tab" id="extra_box">
                                      
                                    </div>                                     
                            </div>
                    </div>
                    <!-- End the Meta Box -->  
                    
                    <!--Start the Summary and SEO Box -->
                    <div class="content-box ">
							<!-- //Render Partial for SEO -->
  							<?php $this->render('cmswidgets.views.object.object_seo_form_widget',array('model'=>$model,'form'=>$form)); ?>
                    </div>
                    <!-- End Summary and SEO Box -->                            
                    </div>

            </div>
    </div>
						
</div>
<br class="clear" />
<?php $this->endWidget(); ?>
</div><!-- form -->

<!-- //Render Partial for Javascript Stuff -->
<?php $this->render('cmswidgets.views.object.object_form_javascript',array('model'=>$model,'form'=>$form,'type'=>$type)); ?>
