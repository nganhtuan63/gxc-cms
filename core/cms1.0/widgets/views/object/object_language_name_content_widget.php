<div id="language-zone">
        <?php if($model->isNewRecord) : ?>
            <?php if(count($versions)>0) : ?>
            <div class="row even border-left-silver">
                    <?php echo "<strong style='color:#DD4B39'>".t("Translated Version of :")."</strong><br />" ?>    

                        <?php foreach($versions as $version) :?>
                        <?php  echo "<br /><b>- ".$version."</b>"; ?>
                        <?php endforeach; ?>
                        
                    <div class="clear"></div>
                    <br />
            </div>
             <?php endif; ?>
             <?php if((int)settings()->get('system','language_number')>1) : ?>
            <div class="row odd border-left-silver">
                    <?php echo $form->labelEx($model,'lang'); ?>	    
                    <?php echo $form->dropDownList($model,'lang',Language::items($lang_exclude),
                            array('id'=>'lang_select','options' => array(array_search(Yii::app()->language,Language::items($lang_exclude,false))=>array('selected'=>true)))
                            
                            ); ?>
                    <?php echo $form->error($model,'lang'); ?>
                    <div class="clear"></div>
            </div>
            <?php else : ?>
                <?php echo $form->hiddenField($model,'lang',array('value'=>Language::mainLanguage())); ?>
            <?php endif; ?>
        <?php endif; ?>
</div>
 <div id="titlewrap">
         <?php echo $form->textField($model,'object_name',array('class'=>'specialTitle','tabindex'=>'1','id'=>'txt_object_name')); ?>
         <?php echo $form->error($model,'object_name'); ?>									
</div>

<div id="small_buttons_insert" align="right">
		<span><?php echo t('Insert'); ?></span>
		<?php
		     $backend_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.backend'), false, -1, false);
		?>
		<img valign="top" alt="Image" title="Image" onClick="insertFileToContent('image');" src="<?php echo $backend_asset; ?>/images/insert_image.png" />
				
</div>
<div id="bodywrap">		
         <?php echo $form->textArea($model,'object_content',array('tabindex'=>'2','class'=>'specialContent','id'=>'ckeditor_content')); ?>
         <?php echo $form->error($model,'object_content'); ?>                                                          
</div>