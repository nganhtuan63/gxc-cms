 <?php
                    $mycs=Yii::app()->getClientScript();                                        
                    $urlScript_ckeditor= bu().'/js/ckeditor/ckeditor.js';
                    $urlScript_ckeditor_jquery=bu().'/js/ckeditor/adapters/jquery.js';
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
            <div id="inner-form-sidebar">
                    <!--Start the publish Box -->
                    <div class="content-box">

                            <div class="content-box-header">


                            <h3><?php echo t('Publish'); ?></h3>

                            </div> 

                            <div class="content-box-content" style="display: block;">

                                    <div class="tab-content default-tab" style="display: block;">

                                        <?php echo $form->label($model,'object_date'); ?>
                                        <?php echo $form->textField($model,'object_date'); ?>
                                        <?php echo $form->error($model,'object_date'); ?>

                                           
                                        <?php $this->render('cmswidgets.views.object.object_workflow',array('form'=>$form,'model'=>$model,'content_status'=>$content_status,'type'=>$type)); ?>
                                    </div>       

                            </div>


                    </div>
                    <!-- End Publish Box -->
                    
                    <?php foreach($terms as $key=>$term) : ?>                                           
                    <?php $this->render('cmswidgets.views.object.object_term',array(
                        'form'=>$form,
                        'model'=>$model,
                        'term'=>$term,
                        'selected_terms'=>$selected_terms,
                        'key'=>$key
                        )); ?>
                    <?php endforeach; ?>
                    
                    <?php if($model->isNewRecord) : ?>
                    <script type="text/javascript">
                     $(document).ready(function() {
                        // We will hide all the term that not belongs to current language
                       changeTermsLanguage();
                       
                       $("#lang_select").change(function() {
                          changeTermsLanguage();
                       });
                     });
                     
                     function changeTermsLanguage(){
                         var current_language=$("#lang_select").val();                          
                         
                         $('.taxonomy_lang_wrap').each(function() {
                             
                            
                             var taxonomy=$(this).attr('id');
                             taxonomy=taxonomy.split('_');
                             
                             //lang=taxonomy[2] and id=taxonomy[1]
                             if(taxonomy[2].toString()!=current_language.toString()){
                                 $(this).hide();
                                 
                                 //We will re-init input checkbox of these terms
                                 $("#selected_terms_"+taxonomy[1]).empty();
                                 $("#list_terms_"+taxonomy[1]).children('span').remove();
                                 
                                 $.each(window['array_term_'+taxonomy[1]], function(k,v) {   
                                       if(!$("#selected_terms_"+taxonomy[1]).children().children('#'+k).length>0){
                                            $('#list_terms_'+taxonomy[1]).append('<span rel="'+v.name+'"><input value="'+v.id+'_'+taxonomy[1]+'" id="'+k+'" onChange="checkATerm'+taxonomy[1]+'(\''+k+'\',this);" type="checkbox" name="terms[]" /> '+v.name+'<br/></span>');
                                       }
                                 });      

                             } else {
                                 $(this).show();
                             }
                             
                             
                          });

                       
                     }
                    </script>
                    <?php endif; ?>
            </div>
    </div>
    <div id="form-body">
            <div id="form-body-content">
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
                    <div class="row">
                        <!--Start Resource Box -->
                        <div class="closed-box content-box ">
                                <div class="content-box-header">
                                <h3><?php echo t('Resources');?></h3>                                
                                </div> 

                                <div class="content-box-content" style="display: block;">
                                        <div class="tab-content default-tab" id="resource_box">
                                           
                                        </div>                                                
                                </div>
                        </div>
                        <!-- End Resource Box -->
                    </div>
                    <div id="bodywrap">
                             <?php echo $form->textArea($model,'object_content',array('tabindex'=>'2','class'=>'specialContent')); ?>
                             <?php echo $form->error($model,'object_content'); ?>
                             
                             
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

                            <div class="content-box-header">


                            <h3><?php echo t('Summary & SEO');?></h3>
                             <ul class="content-box-tabs">
                                <li><a class="default-tab current" href="#summary_box"><?php echo t('Summary');?></a></li>
                                <li><a href="#seo_box" class=""><?php echo t('SEO');?></a></li>
                             </ul>
                            </div> 

                            <div class="content-box-content" style="display: block;">

                                    <div class="tab-content default-tab" id="summary_box">
                                        <?php echo $form->label($model,'object_author_name'); ?>
                                        <?php echo $form->textField($model,'object_author_name',array('id'=>'txt_object_author_name')); ?>
                                        <?php echo $form->error($model,'object_author_name'); ?>
                                        
                                        <?php echo $form->labelEx($model,'tags'); ?>
                                        <?php $this->widget('CAutoComplete', array(
                                                'model'=>$model,
                                                'attribute'=>'tags',
                                                'url'=>array('suggestTags'),
                                                'multiple'=>true,
                                                'htmlOptions'=>array('size'=>50,'id'=>'txt_object_tags'),
                                        )); ?>

                                        <?php echo $form->error($model,'tags'); ?>

                                        <?php echo $form->label($model,'object_excerpt'); ?>
                                        <?php echo $form->textArea($model,'object_excerpt',array('tabindex'=>'3','id'=>'txt_object_excerpt')); ?>
                                        <?php echo $form->error($model,'object_excerpt'); ?>
                                        
                                        <?php echo $form->labelEx($model,'comment_status'); ?>
                                        <?php echo $form->dropDownList($model,'comment_status',  ConstantDefine::getObjectCommentStatus()); ?>
                                        <?php echo $form->error($model,'comment_status'); ?>
                                        
                                        
                                    </div>    
                                    <div class="tab-content" id="seo_box">
                                        
                                        <?php echo $form->label($model,'object_slug'); ?>
                                        <?php echo $form->textField($model,'object_slug',array('id'=>'txt_object_slug')); ?>
                                        <?php echo $form->error($model,'object_slug'); ?>
                                        
                                        <?php echo $form->label($model,'object_title'); ?>
                                        <?php echo $form->textField($model,'object_title',array('id'=>'txt_object_title')); ?>
                                        <?php echo $form->error($model,'object_title'); ?>
                                        
                                        <?php echo $form->label($model,'object_description'); ?>
                                        <?php echo $form->textArea($model,'object_description',array('id'=>'txt_object_description')); ?>
                                        <?php echo $form->error($model,'object_description'); ?>
                                        
                                        <?php echo $form->label($model,'object_keywords'); ?>
                                        <?php echo $form->textArea($model,'object_keywords',array('id'=>'txt_object_keywords')); ?>
                                        <?php echo $form->error($model,'object_keywords'); ?>
                                    </div>       

                            </div>


                    </div>
                    <!-- End Summary and SEO Box -->
                            
                    </div>


            </div>
    </div>
						
</div>
<br class="clear" />

<?php $this->endWidget(); ?>

<script type="text/javascript">

	$(document).ready(function () {
	var config =
	    {
		height: 300,
		width : '100%',
		resize_enabled : false,
		
		toolbar :
		[
		['Source','-','Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','SelectAll','RemoveFormat'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['BidiLtr', 'BidiRtl'],
		['Link','Unlink','Anchor'],
		['Image', 'Media','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe','-','Save','NewPage','Preview','-','Templates','-','Cut','Copy','Paste','PasteText','PasteFromWord'],
		'/',
		['Undo','Redo','-','Find','Replace','-','Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Maximize', 'ShowBlocks','-','About']
		]
	};
	
        //Set for the CKEditor
	$('.specialContent').ckeditor(config);
        
        //Set for the Content Box
        $('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
        $('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
        $('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"

        $('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
                function() { 
                        $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
                        $(this).addClass('current'); // Add class "current" to clicked tab
                        var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
                        $(currentTab).siblings().hide(); // Hide all content divs
                        $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
                        return false; 
                }
        );

        //Minimize the Box
        $(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
		$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
		$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
		
		$(".content-box-header h3").click( // When the h3 is clicked...
			function () {
			  $(this).parent().next().toggle(); // Toggle the Content Box
			  $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
			  $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			}
		);
        
        
        
    });
    
    <?php if($model->isNewRecord) : ?>
    CopyString('#txt_object_name','#txt_object_slug','slug');
    <?php endif; ?>
    CopyString('#txt_object_name','#txt_object_title','');
    CopyString('#txt_object_excerpt','#txt_object_description','');
    CopyString('#txt_object_tags','#txt_object_keywords','');
    

</script>  
</div><!-- form -->
