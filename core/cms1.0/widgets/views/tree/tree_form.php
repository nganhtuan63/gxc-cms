
  

<div class="content-box">
        <div class="content-box-header">


        <h3><?php echo $this->title;?></h3>                             
        </div> 

        <div class="content-box-content" style="display: block; padding: 0 0 15px 0">

                <div class="tab-content default-tab" id="extra_box">
                   <div id='list-item-div'>                    
                    <ul id='list-item-ul' name="list-item" class="ui-sortable" >    
                        <li name="new-item" id="li_item_id-0" align="left" style="display:none;" class="list_item_wrapper">                            
                            <div class="form_item_input" style="display:none;">                                                                
                            </div>
                            
                            <div class="item_div_wrapper">                                                             
                                <span class="item_name"><?php echo t('Item'); ?></span>                                
                                <span class="item_id" style="display:none">0</span>
                                <span class="item_parent_id" style="display:none">0</span>
                                <br />
                                <span class="item_buttons">
                                <a href="javascript:void(0)" onClick="fnEditItem(this);" name="editItem"><?php echo t('Edit'); ?></a> |
                                 <a href="javascript:void(0)" onClick="fnAddNextItem(this);" name="addNextItem"><?php echo t('Add next item'); ?></a> |
                                <a href="javascript:void(0)" onClick="fnAddItem(this);" name="addSubItem"><?php echo t('Add sub item'); ?></a> |                                 
                                <a href="javascript:void(0)" onClick="fnRemoveItem(this);"  name="removeItem"><?php echo t('Remove'); ?></a>  
                                </span>                                
                            </div>
                            
                            <ul name="sub-list-ul" class="ui-sortable">    
                            </ul>                                                      
                        </li>
                    </ul>
                </div>    
                </div>    


        </div>
</div>
<script type="text/javascript">
        var count=1;
        
        function fnAddItem(object){
            $('#list-item-ul li[name="new-item"]:first div.form_item_input:first').show();
            $('#list-item-ul li[name="new-item"]:first div.item_div_wrapper:first').hide();   
            var sub_object=$('li[name="new-item"]:first').clone().attr('name','new-item-'+count);                                        
            //Get the parent space                                         
            var space=parseInt($(object).parent().parent().attr('rel'));
            space=space+50;

            $(sub_object).children("div.item_div_wrapper").attr('style','min-height:35px; padding-left:'+space.toString()+'px; display:none; width:300px');
            $(sub_object).children("div.item_div_wrapper").attr('rel',space.toString());

            var current_parent=$(object).parent().parent().children('span.item_id').html();    
            $(sub_object).children("div.form_item_input").html(
                '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="<?php echo $this->form_create_url; ?>&parent='+current_parent+'" width="100%" onLoad="autoResize(this)" height="30px" />'
            ); 
            sub_object.show().appendTo($(object).parent().parent().next());                                                                                           
            count++; 
        }
        
        function fnAddNextItem(object){
            $('#list-item-ul li[name="new-item"]:first div.form_item_input:first').show();
            $('#list-item-ul li[name="new-item"]:first div.item_div_wrapper:first').hide();   
            var sub_object=$('li[name="new-item"]:first').clone().attr('name','new-item-'+count);                                        
            //Get the parent space                                         
            var space=parseInt($(object).parent().parent().attr('rel'));            

            $(sub_object).children("div.item_div_wrapper").attr('style','min-height:35px; padding-left:'+space.toString()+'px; display:none; width:300px');
            $(sub_object).children("div.item_div_wrapper").attr('rel',space.toString());

            var current_parent=$(object).parent().parent().children('span.item_parent_id').html();   
            
            $(sub_object).children("div.form_item_input").html(
                '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="<?php echo $this->form_create_url; ?>&parent='+current_parent+'" width="100%" onLoad="autoResize(this)" height="30px" />'
            ); 
            sub_object.show().appendTo($(object).parent().parent().next());                                                                                           
            count++; 
        }
        
        function fnEditItem(object){
            var current_id=$(object).parent().parent().children('span.item_id').html();                                        
            var current_parent=$(object).parent().parent().children('span.item_parent_id').html();    
            var update_url='<?php echo $this->form_update_url; ?>&id='+current_id+'&parent='+current_parent;                                    
            $(object).parent().parent().parent().children("div.form_item_input").show();
            $(object).parent().parent().parent().children("div.form_item_input").html(
                '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="'+update_url+'&parent='+current_parent+'" width="100%" onLoad="autoResize(this)" height="30px" />'
            ).show();                                               
            $(object).parent().parent().hide();  
        }
        
        function fnRemoveItem(object){
             if(confirm('<?php echo t('Are you sure you want to delete?'); ?>')){
                var current_id= $(object).parent().parent().children('span.item_id').html();                                           
                var th=object;                                        

                $.ajax({
                  type: 'POST', 
                  dataType: 'json',
                  url: '<?php  echo $this->form_delete_url; ?>?id='+current_id+'&ajax=true',
                  data: { YII_CSRF_TOKEN: '<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>' },
                  success: function(data) {                                             
                      if(data.result=='success'){
                        $(th).parent().parent().parent().remove();
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
        $(document).ready(function() {
            //When new Item Click, clone a menu item and append it to the menu
            $("input[name='btnNewItem']").click(function() {                   

                $('#list-item-ul li[name="new-item"]:first div.form_item_input:first').show();
                $('#list-item-ul li[name="new-item"]:first div.item_div_wrapper:first').hide();   

                var sub_object=$('li[name="new-item"]').clone().attr('name','new-item-'+count);  
                $(sub_object).children("div.item_div_wrapper").attr('style','min-height:35px; display:none; width:300px');
                $(sub_object).children("div.item_div_wrapper").attr('rel','0');

                $(sub_object).children("div.form_item_input").html(
                    '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="<?php echo $this->form_create_url; ?>&parent=0" width="100%" onLoad="autoResize(this)" height="30px" />'
                );            
                sub_object.show().appendTo($("#list-item-ul"));                                                                                      
                count++; 
             });
         
         });
         
        //every list of items must be sortable
        
        $('.ui-sortable').sortable({
                update: function(event, ui) {
                        var data_order = $(this).sortable("serialize");                        
                         $.ajax({
                              type: 'POST', 
                              dataType: 'json',
                              url: '<?php  echo $this->form_change_order_url; ?>',
                              data: { YII_CSRF_TOKEN: '<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>' },
                              success: function(data) {                                             
                                  if(data.result=='success'){
                                    return;
                                  } else {
                                    alert(data.message);  
                                  }
                              },                                          
                              error: function(XHR){     
                                  return; 

                              }
                        });
                        
                }
        });
        





        //Function to handle close Iframe from  Tree Form, update item when adding 
        function closeIframe() {         
            $('#list-item-ul iframe').hide();
        } 


        //Function to handle add item when adding/updating on Tree form
        function updateItemName(object,name,id,parent_id) {              
           $(object).parent().next().children('span.item_name').html(name.toString());   
           $(object).parent().next().children('span.item_id').html(id.toString());            
           $(object).parent().next().children('span.item_parent_id').html(parent_id.toString()); 

           $(object).parent().parent().attr('id','li_item_id-'+id.toLocaleString());
           $(object).parent().next().show();
        } 


       
        function cancelOnCreate(object){
           count--;  
           $(object).parent().parent().remove();
        }
        
        function cancelOnUpdate(object){
           $(object).parent().parent().children('div.form_item_input').children('iframe').attr('src','javascript:void(0)').hide();
           $(object).parent().parent().children('div.item_div_wrapper').show();
        }
    
        function createAppendLi(temp_item,sub){
            if(sub){
                $('#list-item-ul li[name="new-item"]:first div.form_item_input:first').hide();
                $('#list-item-ul li[name="new-item"]:first div.item_div_wrapper:first').show();  

                var sub_object=$('li[name="new-item"]').clone().attr('name','new-item-'+count).attr('id','li_item_id-'+temp_item.id);                                       
                //Get the parent space                                         
                var space=parseInt(($("#li_item_id-"+temp_item.parent).children("div.item_div_wrapper").attr('rel')));
                space=space+50;

                $(sub_object).children("div.item_div_wrapper").attr('style','min-height:35px; padding-left:'+space.toString()+'px; width:300px');
                $(sub_object).children("div.item_div_wrapper").attr('rel',space.toString());

                //Set the id, name and parent value
                $(sub_object).children("div.item_div_wrapper").children('span.item_name').html(temp_item.name.toString());
                $(sub_object).children("div.item_div_wrapper").children('span.item_id').html(temp_item.id.toString());
                $(sub_object).children("div.item_div_wrapper").children('span.item_parent_id').html(temp_item.parent.toString());


                //Add the Iframe Placeholder
                // $(sub_object).children("div.form_item_input").html(
                //   '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="" width="100%" onLoad="autoResize(this)" height="30px" />'
                //); 
            } else {
                $('#list-item-ul li[name="new-item"]:first div.form_item_input:first').hide();
                $('#list-item-ul li[name="new-item"]:first div.item_div_wrapper:first').show();


                var sub_object=$('li[name="new-item"]').clone().attr('name','new-item-'+count).attr('id','li_item_id-'+temp_item.id);  
                $(sub_object).children("div.item_div_wrapper").attr('style','min-height:35px; width:300px');
                $(sub_object).children("div.item_div_wrapper").attr('rel','0');

                //Set the id, name and parent value
                $(sub_object).children("div.item_div_wrapper").children('span.item_name').html(temp_item.name.toString());
                $(sub_object).children("div.item_div_wrapper").children('span.item_id').html(temp_item.id.toString());
                $(sub_object).children("div.item_div_wrapper").children('span.item_parent_id').html(temp_item.parent.toString());

                //Add the Iframe Placeholder
                //$(sub_object).children("div.form_item_input").html(
                //   '<iframe id="iframe_item_'+count+'" name="iframe_item_'+count+'" src="" width="100%" onLoad="autoResize(this)" height="30px" />'
                //);  
            }
                return sub_object;
        }
        
        
        function addItemListOnUpdate(array_item,item_id){
                                         
                                         
                 if(jQuery.inArray(item_id, array_item)) {
                 //Start to work on this item
                 var temp_item=array_item[item_id];
                 if ($("#li_item_id-"+temp_item.id).length >0 ) 
                     return;
                 //If its parent equal 0, we then add it to root list
                                  
                 if(temp_item.parent==0){
                        var sub_object=createAppendLi(temp_item,false);
                        $(sub_object).show().appendTo($('#list-item-ul'));                                         
                        count++;
                 } else {
                         //We will need to check that there is already the 
                         //item with the id has exists      

                        if ($("#li_item_id-"+temp_item.parent).length <= 0 ) {
                              return ;
                        }   
                        var sub_object=createAppendLi(temp_item,true);
                        $(sub_object).show().appendTo($("#li_item_id-"+temp_item.parent).children('ul:eq(0)'));   
                        count++;                                                                                                                                                                                              
                     }        
                 }
             
            
         }
          $(document).ready(function() {                       
          <?php  if (count($this->list_items)>0) : ?>               
               // PHP Array to Javascript array
               <?php  echo 'var array_item='.json_encode($this->list_items).';'; ?>                   
                $.each(array_item, function(k,v) {                       
                     addItemListOnUpdate(array_item,k);                     
                });  
                
                  $('.ui-sortable').sortable({
                                        update: function(event, ui) {
                                                var data_order = $(this).sortable("serialize");
                                               
                                                 $.ajax({
                                                      type: 'POST', 
                                                      dataType: 'json',
                                                      url: '<?php  echo $this->form_change_order_url; ?>',
                                                      data: { YII_CSRF_TOKEN: '<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>', data : data_order },
                                                      success: function(data) {                                             
                                                          if(data.result=='success'){
                                                            return;
                                                          } else {
                                                            alert(data.message);  
                                                          }
                                                      },                                          
                                                      error: function(XHR){     
                                                          return; 

                                                      }
                                                });

                                        }
                                });

          <?php endif;  ?>
         });
              
</script>
<div style="border-bottom:1px dotted #CCC; padding-bottom: 10px">
<?php echo CHtml::button(t('New item'),array('class'=>'button','name'=>'btnNewItem')); ?> 
</div>

