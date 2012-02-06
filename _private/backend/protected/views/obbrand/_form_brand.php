<div class="form">
<?php $this->renderPartial('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brand-form',
	'enableAjaxValidation'=>true,
)); ?>


<?php echo $form->errorSummary($model); ?>
    <div class="left">
    <div class="row">
            <?php echo $form->labelEx($model,'brand_name'); ?>
            <?php echo $form->textField($model,'brand_name',array()); ?>
            <?php echo $form->error($model,'brand_name'); ?>

    </div>    
    
    <div class="row">
        <?php echo $form->labelEx($model,'brand_slug'); ?>
        <?php echo $form->textField($model,'brand_slug',array()); ?>
        <?php echo $form->error($model,'brand_slug'); ?>
        
    </div>
    
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_site'); ?>
        <?php echo $form->textField($model,'brand_site',array()); ?>
        <?php echo $form->error($model,'brand_site'); ?>
        
    </div>
        
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_affiliate'); ?>
        <?php echo $form->textField($model,'brand_affiliate',array()); ?>
        <?php echo $form->error($model,'brand_affiliate'); ?>
        
    </div>
    </div> 
    <div class="left" style="margin-left:20px;">
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_allow_crawl',array('class'=>'labelInline')); ?>
        <?php echo $form->checkBox($model,'brand_allow_crawl',array('class'=>'brandCheckBox')); ?>
        <?php echo $form->error($model,'brand_allow_crawl'); ?>
        
    </div>
    
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_allow_parse',array('class'=>'labelInline')); ?>
        <?php echo $form->checkBox($model,'brand_allow_parse',array('class'=>'brandCheckBox')); ?>
        <?php echo $form->error($model,'brand_allow_parse'); ?>
        
    </div>
    
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_active',array('class'=>'labelInline')); ?>
        <?php echo $form->checkBox($model,'brand_active',array('class'=>'brandCheckBox')); ?>
        <?php echo $form->error($model,'brand_active'); ?>
        
    </div>
    
    <div class="row  ">
        <?php echo $form->labelEx($model,'brand_mix',array('class'=>'labelInline')); ?>
        <?php echo $form->checkBox($model,'brand_mix',array('class'=>'brandCheckBox')); ?>
        <?php echo $form->error($model,'brand_mix'); ?>
        
    </div>
    </div>
    <div class="clear"></div>

    <?php if(!$model->isNewRecord) : ?>
        <div class="row">
            
            <div class="content-box ">
            <div class="content-box-header">
            <h3><?php echo t('Brand Fetch List');?></h3>                                
            </div> 
                
            <div class="content-box-content" style="display: block; padding: 0 0 15px 0">
                    <div class="tab-content default-tab">
                            
                                    <ul id="fetch_list_manual" class="box_list">
                                            
                                        </ul>  
                                    <div style="padding:15px">                               
                                                
                                        <iframe id="frame_for_fetch_brand" src="" width="100%" height="30x" onLoad="autoResize(this);" style="border:1px dotted #CCC; display:none"></iframe>    
                                        
                                          <script type="text/javascript">

                                            <?php 
                                                if (is_array($arr_fetch) && !empty($arr_fetch) > 0)  : ?>
                                            
                                            <?php       
                                                    $content_items=array();
                                                    foreach($arr_fetch as $obj_id){
                                                        $temp_object=  ProductFetch::model()->findByPk($obj_id);
                                                        if($temp_object){
                                                            $content_items['item_'.$temp_object->pf_id]['id']=$temp_object->pf_id;
                                                            $content_items['item_'.$temp_object->pf_id]['title']='Fetch Id - '.$temp_object->pf_id;
                                                        }
                                                    }

                                                    echo 'var fetch_list = '.json_encode($content_items).';'; 
                                            ?>
                                                    $.each(fetch_list, function(k,v) {                        
                                                             setFetchList(v.title,v.id);              
                                                    }); 

                                            <?php endif; ?>
                                                
                                                
                                                function closeIframeFetch(){
                                                    $('#frame_for_fetch_brand').attr('src','');
                                                    $('#frame_for_fetch_brand').hide();

                                                }
                                                
                                                function addNewFetch(){
                                                    $('#frame_for_fetch_brand').attr('src','   <?php echo bu().'/obfetch/create/embed/iframe/brand/'.$model->brand_id;?>');
                                                    $('#frame_for_fetch_brand').show();
                                                                                                    
                                                }

                                                function setFetchList(linkTitle,linkId){   
                                                         
                                                   var nextli='list_id_fetch_list_'+linkId;    
                                                   if($('#'+nextli).length<=0){
                                                           //Update the number for the Upload Count;
                                                        var current_count=$('#current_fetch_list_count').html();
                                                        current_count=parseInt(current_count);
                                                        current_count++;
                                                        $('#current_fetch_list_count').html(current_count.toString());

                                                        var li='<li class="box_list_item" id=\"'+nextli+'\"><input type=\"hidden\" name=\"fetch_list_title[]\" id=\"input_title_'+nextli+'\" value=\"'+linkTitle+'\" /><input type=\"hidden\" name=\"fetch_list_id[]\" id=\"input_id_'+nextli+'\" value=\"'+linkId+'\" /><a href="javascript:void(0);" onClick="editFetchList('+linkId+')" >'+linkTitle+'</a> - <a href=\"javascript:void(0);\" onClick=\"deleteFetchList(\''+nextli+'\','+linkId+');\">Delete</a></li>';        


                                                        $('#fetch_list_manual').append(li);
                                                    }        
                                                 
                                                    return;

                                                }
                                                
                                                function editFetchList(id){
                                                    $('#frame_for_fetch_brand').attr('src','<?php echo bu().'/obfetch/update/embed/iframe/id';?>/'+id);
                                                    $('#frame_for_fetch_brand').show();
                                                }

                                                function deleteFetchList(id,id_number){
                                                    
                                                   if(confirm('Are you sure you want to delete? ')) {
                                                        $.ajax({
                                                          type: 'POST', 
                                                          dataType: 'json',
                                                          url: '<?php echo bu().'/obfetch/delete/ajax/true/id'; ?>/'+id_number,
                                                          data: { YII_CSRF_TOKEN: '<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>' },
                                                          success: function(data) {                                             
                                                              if(data.result=='success'){
                                                                 var current_count=$('#current_fetch_list_count').html();
                                                                 current_count=parseInt(current_count);
                                                                 current_count--;
                                                                 if(current_count<0) current_count=0;
                                                                 $("#"+id).remove();
                                                                 $('#current_fetch_list_count').html(current_count.toString());
                                                              } else {
                                                                alert(data.message);  
                                                              }
                                                          },                                          
                                                          error: function(XHR){     
                                                              return; 

                                                          }
                                                        });
                                                    
                                                    }

                                                   
                                                }

                                        </script>
                                    <span id="current_fetch_list_count" style="display:none">0</span>                                
                                    
                                    </div>
                                                                                         
                                 
                                   
                            
                    </div>                                                
                </div>
            </div>
            <input type="button" class="button" onClick="addNewFetch();" value="Add New Fetch" />
        </div>
    <?php endif; ?>
    
    
               
<?php if (!$model->isNewRecord) : ?>
<div class="row" style="border-top:1px dotted #CCC; padding-top:20px"> 
<?php 
$form_create_url=Yii::app()->controller->createUrl('obbrandpage/create',array('embed'=>'iframe','brand'=>$model->brand_id));    
$form_update_url=Yii::app()->controller->createUrl('obbrandpage/update',array('embed'=>'iframe','brand'=>$model->brand_id));    
$form_change_order_url=Yii::app()->controller->createUrl('obbrandpage/changeorder',array());    
$form_delete_url=Yii::app()->controller->createUrl('obbrandpage/delete',array());  

$this->widget('cmswidgets.TreeFormWidget',array('title'=>t('Brand Pages'),    
    'form_create_url'=>$form_create_url,
    'form_update_url'=>$form_update_url,
    'form_change_order_url'=>$form_change_order_url,
    'form_delete_url'=>$form_delete_url,    
    'list_items'=>isset($list_items) ? $list_items : array()
    )); ?>
</div>
<?php endif; ?>  
        
    
    
    <div class="row  buttons ">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
        <div class="clear"></div> 
    </div>
    
       
    
   
    
<?php $this->endWidget(); ?>

</div><!-- form -->