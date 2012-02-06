<div name="div-block-content-<?php echo $block_model->id;?>">
 
<div class="row">
<div class="content-box ">
        <div class="content-box-header">
        <h3><?php echo t('Content list');?></h3>                                
        </div> 

        <div class="content-box-content" style="display: block; padding: 0 0 15px 0">
                <div class="tab-content default-tab">
                         
                            <ul id="content_list" style="margin:0px 0 10px 0px">

                            </ul>

                </div>                                                
        </div>
</div>	
 
</div>
<p><?php echo '<b>'.t('Note:').'</b> '.t('When you create a content list here, it will appear on the above Content list box'); ?></p>
<div class="row" style="border:1px dotted #CCC">
        
      <iframe id='contentlist_iframe'  src="<?php echo Yii::app()->request->baseUrl;?>/becontentlist/create/embed/iframe" frameborder="0" onLoad="autoResize(this);" height="30px" width="100%"></iframe>
</div>           
<script type="text/javascript">
     <?php  if ((is_array($block_model->content_list)) && (!empty($block_model->content_list))) : ?>               
            
             <?php       
                    $content_items=array();
                    foreach($block_model->content_list as $obj_id){
                        $temp_object=ContentList::model()->findByPk($obj_id);
                        if($temp_object){
                            $content_items['item_'.$temp_object->content_list_id]['id']=$temp_object->content_list_id;
                            $content_items['item_'.$temp_object->content_list_id]['title']=$temp_object->name;
                        }
                    }

                    echo 'var manual_content_list = '.json_encode($content_items).';'; 
             ?>
                    $.each(manual_content_list, function(k,v) {                        
                             addContentList(v.title,v.id);              
                    }); 
                           
     <?php endif;  ?>
         
     function addContentList(linkTitle,linkId){
         
         if($('#item_'+linkId).length>0){             
             $('#input_title_item_'+linkId).val(linkTitle);
             $('#link_item_title_item_'+linkId).html(linkTitle);
         } else {
            var nextli='item_'+linkId;
            var li='<li id=\"'+nextli+'\"><input type=\"hidden\" name=\"content_list_title[]\" id=\"input_title_'+nextli+'\" value=\"'+linkTitle+'\" /><input type=\"hidden\" name=\"Block[content_list][]\" id=\"input_id_'+nextli+'\" value=\"'+linkId+'\" /><a id=\"link_item_title_'+nextli+'\" href=\"javascript:void(0);\" onClick=\"updateContentList(\''+linkId+'\');\" target="_blank">'+linkTitle+'</a> - <a href=\"javascript:void(0);\" onClick=\"deleteContentList(\''+nextli+'\');\">Delete</a></li>';        
            $('#content_list').append(li);
            return;
         }
       
     }
     
     function deleteContentList(id){        
         $("#"+id).remove();
     }
                                    
     $('#content_list').sortable();
     
     function updateContentList(id) {
        $('#contentlist_iframe').attr('src','<?php echo Yii::app()->request->baseUrl;?>/becontentlist/update/id/'+id+'/embed/iframe');
     }
     
      //Function to handle close Iframe from  Tree Form, update item when adding 
     function resetIframe() {         
        $('#contentlist_iframe').attr('src','<?php echo Yii::app()->request->baseUrl;?>/becontentlist/create/embed/iframe');
     } 


     

     
</script>
</div>
