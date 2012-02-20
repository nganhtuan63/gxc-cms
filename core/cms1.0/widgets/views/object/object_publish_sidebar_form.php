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