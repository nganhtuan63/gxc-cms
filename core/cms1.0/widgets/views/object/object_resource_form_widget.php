 <script type="text/javascript">
 function buildResourceList(id,link,key,file_type){
    	var current_resource_count=parseInt($('#resource_upload_'+key+'_current_upload_count').val());
    	var current_resource_max=parseInt($('#resource_upload_'+key+'_current_upload_max').val());
    	var next_resource_count=current_resource_count+1;
    							    	
    	var link_resource_icon='<?php echo Yii::app()->controller->backend_asset;?>/images/content_icons/'+file_type+'.png';
    	if(file_type=='image'){
    		link_resource_icon=link;
    	}
    		$('#resource_upload_'+key+'_current_upload_count').val(next_resource_count);
	    	var resource_string=
			'<li id="list_id_resource_upload_'+key+'_'+next_resource_count+'" align="left" style="background: transparent; float:left" >'+
				'<input type="hidden" id="upload_id_resource_upload_'+key+'_link_'+next_resource_count+'" name="upload_id_resource_upload_'+key+'_link[]" value="'+link+'" />'+
				'<input type="hidden" id="upload_id_resource_upload_'+key+'_resid_'+next_resource_count+'" name="upload_id_resource_upload_'+key+'_resid[]" value="'+id+'" />'+
				'<input type="hidden" id="upload_id_resource_upload_'+key+'_type_'+next_resource_count+'" name="upload_id_resource_upload_'+key+'_type[]" value="'+file_type+'" />'+                            							                           
	            '<div class="item_div_wrapper">'+                                                             
	                '<span class="item_name"><img style="background:#fff;padding:5px; border:1px dotted #CCC" src="'+link_resource_icon+'" width="50" /></span>'+                                                								                               							                
	                '<div class="item_buttons" style="margin-top:3px; margin-left:5px">'+
	                '<a href="<?php echo bu();?>/beresource/update/'+id+'" target="_blank"  name="editItem"><img alt="<?php echo t('Edit'); ?>" src="<?php echo Yii::app()->controller->backend_asset; ?>/images/edit.png" /></a>&nbsp;'+							                                            
	                '<a href="javascript:void(0)" onclick="fnRemoveResourceItem(\'list_id_resource_upload_'+key+'_'+next_resource_count+'\',\''+key+'\');" name="removeItem"><img alt="<?php echo t('Delete'); ?>" src="<?php echo Yii::app()->controller->backend_asset;?>/images/disabled.png" /></a>'+  
	                '</div>'+                                
	            '</div>'+							                                                                                 
		 	'</li><li class="clear"></li>';
		 	$('#'+key+'_resource_list li.clear').remove();
		 	$('#'+key+'_resource_list').append(resource_string);		 			 	
		 	$('#resource_upload_'+key+'_current_upload_count').val(next_resource_count.toString());
		 	$('#resource_upload_modified').val(1);	 			
}

function fnRemoveResourceItem(item,key){
   	
   	$("#"+item).remove();
   	var current_count=$('#resource_upload_'+key+'_current_upload_count').val();
   	current_count=parseInt(current_count);
   	current_count=current_count-1;
	if(current_count<0) current_count=0;
	$('#resource_upload_'+key+'_current_upload_count').val(current_count.toString());
	$('#resource_upload_modified').val(1);
	
}

function sortResourceList(){
	$('.resource_list').sortable({
	   update: function(event, ui) {
	   		$('#resource_upload_modified').val(1);

	   },
	   change: function(event, ui) {
	   		var key=$(this).attr('id').toString().replace('_resource_list','');
	   		$('#resource_upload_modified').val(1);						   		
	   }
	});
}
			    	 
function doUploadResource(type){
	var current_resource_count=parseInt($('#resource_upload_'+type+'_current_upload_count').val());
	var current_resource_max=parseInt($('#resource_upload_'+type+'_current_upload_max').val());
	var next_resource_count=current_resource_count+1;    	
	if(next_resource_count<=current_resource_max){
		$.prettyPhoto.open('<?php echo bu();?>/beresource/createframe?content_type=<?php echo $type;?>&parent_call=true&type='+type+'&iframe=true&height=400','<?php echo t('Upload Resource');?>','');
	} else {
		alert('<?php echo t('Max file Upload Reached!'); ?>');
		return false;
	}
	
}

function afterUploadResource(resource_id,resource_path,type,file_type){    
	buildResourceList(resource_id,resource_path,type,file_type);	
	$.prettyPhoto.close();
	return;    	
}
</script>
<!--Start Resource Box -->
<div class="content-box ">
        <div class="content-box-header">
        <h3><?php echo t('Resources');?></h3>    
        
        <ul class="content-box-tabs">                                	
			<?php 																										
				if (is_array($content_resources)&&(count($content_resources)>0)) :
        	?>                                		
            	<?php foreach ($content_resources as $key=>$value) : ?>
            		<li><a class="" href="#<?php echo $key; ?>_box"><?php echo $value['name']; ?></a></li>
        		<?php endforeach; ?>
    		<?php endif; ?>
           
     	</ul>                            
        </div> 

        <div class="content-box-content" id="resource-box-content" style="display: block; padding:0px">
        	<input type="hidden" id="resource_upload_modified" value="0" />
        	<?php 											
        																	
				if (is_array($content_resources)&&(count($content_resources)>0)) :
        	?>                                		
            	<?php foreach ($content_resources as $key=>$value) : ?>
            		<div class="tab-content" id="<?php echo $key; ?>_box">
            				                                			
            			<div>
            				<?php
            						if($model->isNewRecord){
            							$list_current_resource=GxcHelpers::getArrayResourceObjectBinding('resource_upload_'.$key);
									} else {
										$list_current_resource=GxcHelpers::getResourceObjectFromDatabase($model,$key);																
									}																														
            				?>
            					
            				<input type="hidden" id="resource_upload_<?php echo $key; ?>_current_upload_max" value="<?php echo $value['max']; ?>" />	                                					
            				<input type="hidden" id="resource_upload_<?php echo $key; ?>_current_upload_count" value="0" />
            				
            				
            				<ul class="resource_list" id="<?php echo $key; ?>_resource_list" style="margin:0; padding:0px; clear:both;" >	                                					
            					<script type="text/javascript">
            					<?php 
									if(count($list_current_resource)>0) :
            						foreach($list_current_resource as $current_resource) :																							
            					?>
            						buildResourceList('<?php echo $current_resource['resid']; ?>','<?php echo $current_resource['link']; ?>','<?php echo $key; ?>','<?php echo $current_resource['type']; ?>');
            					<?php 
            						
            						endforeach; 															
									endif;
            					?>
            					
            					</script>

            				</ul>
            			</div>
            			<div class="button_add" style="text-align:right; padding-right:10px; padding-top:10px; padding-bottom:10px">
                   			<input type="button" onClick="return doUploadResource('<?php echo $key; ?>');" class="bebutton active" name="<?php echo $key; ?>_button" id="<?php echo $key; ?>_button" value="<?php echo t('Add'); ?>"/>
                   		</div>
                	</div> 
        		<?php endforeach; ?>
    		<?php endif; ?>
    		<script type="text/javascript">
    			$('#resource_upload_modified').val(0);
            	sortResourceList();
    		</script>
           
           
                                                                                                     
        </div>
</div>
<!-- End Resource Box -->