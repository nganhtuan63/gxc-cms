<div class="form">   
      
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'page-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>
    
 
<div id="language-zone">
<?php if($model->isNewRecord) : ?>
    <?php if(count($versions)>0) : ?>
    <div class="row">
            <?php echo "<strong style='color:#DD4B39'>".t("Translated Version of :")."</strong><br />" ?>    

                <?php foreach($versions as $version) :?>
                <?php  echo "<br /><b>- ".$version."</b>"; ?>
                <?php endforeach; ?>


            <br />
    </div>
     <?php endif; ?>
     <?php if((int)settings()->get('system','language_number')>1) : ?>
    <div class="row">
            <?php echo $form->labelEx($model,'lang'); ?>	    
            <?php echo $form->dropDownList($model,'lang',Language::items($lang_exclude),
                    array('options' => array(array_search(Yii::app()->language,Language::items($lang_exclude,false))=>array('selected'=>true)))
                    ); ?>
            <?php echo $form->error($model,'lang'); ?>
            <div class="clear"></div>
    </div>
    <?php else : ?>
        <?php echo $form->hiddenField($model,'lang',array('value'=>Language::mainLanguage())); ?>
    <?php endif; ?>
<?php endif; ?>
</div>


<div>   
    <div class="left">
        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row" >
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title'); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
        <div class="row" >
            <?php echo $form->labelEx($model,'slug'); ?>
            <?php echo $form->textField($model,'slug'); ?>
            <?php echo $form->error($model,'slug'); ?>
        </div>
    </div>
    <div class="left" style="margin-left:20px">
         <div class="row">
                <?php echo $form->labelEx($model,'keywords'); ?>
                <?php echo $form->textField($model,'keywords',array()); ?>
                <?php echo $form->error($model,'keywords'); ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'description'); ?>
                <?php echo $form->textArea($model,'description',array('style'=>'min-height:70px')); ?>
                <?php echo $form->error($model,'description'); ?>
        </div>
      
        
    </div>
    <div class="clear"></div>
</div>    
   <div class="row">
       
                <?php echo $form->labelEx($model,'status',array('style'=>'display:inline')); ?>
                <?php echo $form->dropDownList($model,'status',  ConstantDefine::getPageStatus() ,
                       array()
                        ); ?>
                <?php echo $form->error($model,'status'); ?>
       
   </div>   
    <div class="row">        
            <?php echo $form->checkBox($model,'allow_index',array()); ?>
            <?php echo $form->labelEx($model,'allow_index',array('style'=>'display:inline')); ?>
            <?php echo $form->error($model,'allow_index'); ?>
           
            
            <?php echo $form->checkBox($model,'allow_follow',array()); ?>
            <?php echo $form->labelEx($model,'allow_follow',array('style'=>'display:inline')); ?>
            <?php echo $form->error($model,'allow_follow'); ?>
     
   </div>
 
  
    <div class="row" style="border-top: 1px dotted #CCC; padding-top:20px">
       <?php echo $form->labelEx($model,'parent'); ?>
        <p class="hint"><?php echo t('Use Select box or Autocomplete box for Parent Select : ');?></p>
        <?php echo CHtml::dropDownList('parent', $model->parent ,  Page::getParentPages(false,$model->page_id) ,
                    array('id'=>'parent_page_select')
                    ); ?>        
        
        <?php $this->widget('CAutoComplete', array(                                                    
                                                    'name'=>'suggest_page',
                                                    'url'=>array('suggestPage'),
                                                    'value'=>Page::getPageName($model->parent),
                                                    'multiple'=>false,
                                                    'mustMatch'=>true,
                                                    'htmlOptions'=>array('size'=>50,'class'=>'maxWidthInput','id'=>'form_suggest_page'),
                                                    'methodChain'=>".result(function(event,item){ if(item!==undefined) \$(\"#parent_value\").val(item[1]); \$(\"#parent_page_select\").val(item[1])})",
                                            )); ?>
        
        <input onClick="return changePageParent();" type="button" class="button" name="btnchangeParent" value="<?php echo t('Apply Parent Blocks');?>" />                      
        <?php echo $form->hiddenField($model,'parent',array('id'=>'parent_value','value'=>$model->parent===null ? 0 : $model->parent)); ?>
        <?php echo $form->error($model,'parent'); ?>
        <script type="text/javascript">
            $('#parent_page_select').change(function() {
                $('#parent_value').val( $('#parent_page_select').val());
                $('#form_suggest_page').val( $('#parent_page_select option:selected:first').html());
            });
        </script>
        
    </div>
    <div class="row">
       <?php echo $form->labelEx($model,'layout'); ?>
       <?php echo $form->dropDownList($model,'layout',  GxcHelpers::getAvailableLayouts(true),
                      array('id'=>'layout_select', 'options' => $model->layout===null ?  array('default'=>array('selected'=>true)) : array($model->layout=>array('selected'=>true)) )                                            
                    ); ?>
        <?php echo $form->error($model,'layout'); ?>
        
      
    </div>
    
       
    <div class="row">
       
                <?php echo $form->labelEx($model,'display_type',array()); ?>
                <?php echo $form->dropDownList($model,'display_type',  array(),
                       array('id'=>'display_type_option')
                        ); ?>
                <?php echo $form->error($model,'display_type'); ?>
       
   </div> 
    
      <?php if(!$model->isNewRecord) : ?>
        <input onClick="return turnBack();" type="button" class="button" name="btnturnBack" value="<?php echo t('Turn back');?>" />                      
        <?php endif; ?>
    
    <div class="row" style="border-bottom:1px dotted #CCC; padding:0px 0px 20px 0">
       
        <ul id="page-regions-list">          
        </ul>
        
        <div id="page-regions-wrapper">
        </div>
        <div id="block-buttons" style="margin-top:30px">
            <input type="button" class="button" onClick="inheritFromParent();" name="inherit-parent-block" value="<?php echo t('Inherit from Parent'); ?>" />
            <input type="button" class="button" onClick="addExistedBlock();" name="add-existed-block" value="<?php echo t('Add existed Block'); ?>" />
            <input type="button" class="button" onClick="addNewBlock();" name="add-new-block" value="<?php echo t('Add new Block'); ?>" />
        </div>
    </div>
    
  

    <div class="row">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
    </div>


<?php $this->endWidget(); ?>
</div><!-- form -->
<script type="text/javascript">        
    
    //Function to get the Page Regions    
    var block_count=0;
                
    
    function changeCheckAll(object){                      
                var current_region=$('a.tab-current:first').attr('rel');
                current_region=current_region.split('_');
                current_region=current_region[2];         
                if($(object).is(':checked')){                        
                    $('#ul_region_'+current_region).find('.checkbox_region ').prop('checked', true);
                } else {
                    $('#ul_region_'+current_region).find('.checkbox_region ').prop('checked', false);
                }
            }
            
    function changeCheckAllDiv(object){      
                
                 if (!$(object).children('.check-all-button:first').is(':hover')) {
                        if($(object).children('.check-all-button:first').is(':checked')){
                            $(object).children('.check-all-button:first').prop('checked', false);    
                            changeCheckAll($(object).children('.check-all-button:first'));
                        } else 
                            $(object).children('.check-all-button:first').prop('checked', true);
                            changeCheckAll($(object).children('.check-all-button:first'));   
                     }
                     
              
    }           
    
  
    
    function doActive(key){
        $('#ul_region_'+key).find('input:checkbox:checked').each(function() {
            $(this).parent('li').find('select:first').val(<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>);
        });
    }
    
    function doDisable(key){
        $('#ul_region_'+key).find('input:checkbox:checked').each(function() {
            $(this).parent('li').find('select:first').val(<?php echo ConstantDefine::PAGE_BLOCK_DISABLE; ?>);
        });
    }
    
    function doDelete(key){
        $('#ul_region_'+key).find('input:checkbox:checked').each(function() {
            $(this).parent('li').remove();     
        });
      
        $('#div_region_'+key).find('input[type=checkbox]:first').prop('checked', false);      
      
      
        
    }

    function changePageParent(){                
            <?php 
            echo CHtml::ajax(array(                            
            'url'=>array('changeParent'),                             
            'data'=>array(
                          'parent'=>'js:$(\'#parent_value\').val()',                          
                          'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                            ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {    
                block_count=0;
                createRegionsFromJson(data);
                reSetBlocksByParent(data);               
            } ",
            ));?>
    }
    
    function inheritFromParent(){        
        //Get the current Tab index
        var current_region=$('a.tab-current:first').attr('rel');
        current_region=current_region.split('_');
        current_region=current_region[2];                                
        <?php 
            echo CHtml::ajax(array(                            
            'url'=>array('inheritParent'),                             
            'data'=>array(
                          'parent'=>'js:$(\'#parent_value\').val()', 
                          'region'=>'js:current_region',   
                          'layout'=>'js:$(\'#layout_select\').val()', 
                          'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                            ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {                                    
                $.each(data, function(key_parent, val_parent){                       
                    if(key_parent=='blocks'){               
                            $('#ul_region_'+current_region).empty();
                            $.each(val_parent, function(k,v) {                                 
                                 setBlocksForRegion(v.region,v.title,v.id,v.status);              
                            });
                    }
                });
            } ",
            ));?>                   
    }
    
    function turnBack(){
            <?php 
            echo CHtml::ajax(array(                            
            'url'=>array('changeParent'),                             
            'data'=>array(
                          'parent'=>$model->page_id,                          
                          'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                            ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {    
                block_count=0;
                createRegionsFromJson(data);
                reSetBlocksByParent(data);               
            } ",
            ));?>
    }
    
    function reSetBlocksByParent(data){
         $.each(data, function(key_parent, val_parent){                       
                if(key_parent=='blocks'){                    
                        $.each(val_parent, function(k,v) {                                 
                             setBlocksForRegion(v.region,v.title,v.id,v.status);              
                        });
                }
        });
    }
    
    
    function getRegionsByLayouts(){
        <?php 
            echo CHtml::ajax(array(                            
            'url'=>array('changeLayout'),                             
            'data'=>array('layout'=>'js:$(\'#layout_select\').val()',                                                 
                          'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                            ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {    
                block_count=0;
                createRegionsFromJson(data);
                initBlocks();
            } ",
            ));?>
    }
    
    function setBlocksForRegion(region,title,id,status){
        var span_html='<input type="checkbox" class="checkbox_region" id="checkbox_'+block_count+'_'+region+'_'+id+'"/><span class="span_block">'+title+'</span> - <span><select name="Page[regions]['+region+'][status][]" id="select_region_'+block_count+'_'+region+'_'+id+'"><option value="<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>"><?php echo PageBlock::convertPageBlockStatus(ConstantDefine::PAGE_BLOCK_ACTIVE);?></option><option value="<?php echo ConstantDefine::PAGE_BLOCK_DISABLE; ?>"><?php echo PageBlock::convertPageBlockStatus(ConstantDefine::PAGE_BLOCK_DISABLE);?></option></select> </span> <br /><a onClick="changeAnotherBlock('+region+','+id+','+block_count+')" href="javascript:void(0);"><?php echo t('Change');?></a>&nbsp;<a onClick="editBlock('+region+','+id+','+block_count+')" href="javascript:void(0);"><?php echo t('Edit');?></a>&nbsp;<a onClick="deleteBlockFromRegion(this)" href="javascript:void(0);"><?php echo t('Delete');?></a>';
        var input_id_html='<input type="hidden" value="'+id+'" name="Page[regions]['+region+'][id][]" />';
        var input_status_html='<input type="hidden" value="<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>" />';
        var iframe_html='<div style="display:none" class="li_region_iframe"><iframe rel="'+region+'" id="iframe_region_'+block_count+'_'+region+'_'+id+'" src="<?php echo $this->add_existed_block_url; ?>" width="100%" onLoad="autoResize(this)" height="30px" /></div>';
        var li_html='<li class="li_region" id="li_region_'+block_count+'_'+region+'_'+id+'">'+span_html+input_id_html+input_status_html+iframe_html+'</li>';                
        $('#ul_region_'+region).append(li_html); 
        $('#select_region_'+block_count+'_'+region+'_'+id).val(status);
        block_count++;
    }
    
    function updateBlock(region,title,id,old_object){
        
        var old_id=$(old_object).attr('id');        
        var old_block_count=old_id.split('_');
        old_block_count=old_block_count[2];
        var span_html='<input type="checkbox" class="checkbox_region" id="checkbox_'+old_block_count+'_'+region+'_'+id+'"/><span class="span_block">'+title+'</span> - <span><select name="Page[regions]['+region+'][status][]" id="select_region_'+old_block_count+'_'+region+'_'+id+'"><option value="<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>"><?php echo PageBlock::convertPageBlockStatus(ConstantDefine::PAGE_BLOCK_ACTIVE);?></option><option value="<?php echo ConstantDefine::PAGE_BLOCK_DISABLE; ?>"><?php echo PageBlock::convertPageBlockStatus(ConstantDefine::PAGE_BLOCK_DISABLE);?></option></select> </span> <br /><a onClick="changeAnotherBlock('+region+','+id+','+old_block_count+')" href="javascript:void(0);"><?php echo t('Change');?></a>&nbsp;<a onClick="editBlock('+region+','+id+','+old_block_count+')" href="javascript:void(0);"><?php echo t('Edit');?></a>&nbsp;<a onClick="deleteBlockFromRegion(this)" href="javascript:void(0);"><?php echo t('Delete');?></a>';
        var input_id_html='<input type="hidden" value="'+id+'" name="Page[regions]['+region+'][id][]" />';
        var input_status_html='<input type="hidden" value="<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>" name="Page[regions]['+region+'][status][]" />';
        var iframe_html='<div style="display:none" class="li_region_iframe"><iframe rel="'+region+'" id="iframe_region_'+old_block_count+'_'+region+'_'+id+'" src="<?php echo $this->add_existed_block_url; ?>" width="100%" onLoad="autoResize(this)" height="30px" /></div>';       
        $(old_object).empty().append(span_html+input_id_html+input_status_html+iframe_html).attr('id','li_region_'+old_block_count+'_'+region+'_'+id);
    }
        
    function deleteBlockFromRegion(object){               
        $(object).parent().remove();         
    }
    
    function changeAnotherBlock(region,id,count){         
        
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').children('iframe').attr('src','<?php echo $this->add_existed_block_url; ?>');
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').children('iframe').attr('height','30px');
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').show();
    }
    
    function editBlock(region,id,count){         
        
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').children('iframe').attr('src','<?php echo $this->update_block_url; ?>&id='+id);
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').children('iframe').attr('height','30px');
        $('#li_region_'+count+'_'+region+'_'+id).children('div.li_region_iframe').show();
    }
    
    function cancelOnAddBlock(object){
        $(object).attr('src','');
        $(object).attr('height','30px');        
        $(object).parent().hide();
    }
    
    function updateOnAddBlock(object,title,id){        
        var current_region=$(object).attr('rel');
        $(object).attr('src','');
        $(object).attr('height','30px');
        $(object).parent().hide();    
        
        //We will check if this is a new Block or Change Block
        if ($(object).parent().attr('class')=='region_iframe'){
            setBlocksForRegion(current_region,title,id,<?php echo ConstantDefine::PAGE_BLOCK_ACTIVE; ?>);                
        } else {
            updateBlock(current_region,title,id,$(object).parent().parent());
        }
        
    }

    
    function addExistedBlock(){        
        //Get the current Tab index
        var current_region=$('a.tab-current:first').attr('rel');
        current_region=current_region.split('_');
        current_region=current_region[2];                                
        $('#iframe_region_'+current_region).attr('src','<?php echo $this->add_existed_block_url; ?>');
        $('#iframe_region_'+current_region).attr('height','30px');
        $('#div_iframe_region_'+current_region).show();                
    }
    
    function addNewBlock(){
        var current_region=$('a.tab-current:first').attr('rel');
        current_region=current_region.split('_');
        current_region=current_region[2];
                                
        $('#iframe_region_'+current_region).attr('src','<?php echo $this->add_new_block_url; ?>/embed/iframe');
        $('#div_iframe_region_'+current_region).show();
    }
    
    
    function createRegionsFromJson(data){
        
         $('#page-regions-list').empty();
         $('#page-regions-wrapper').empty();
         
         $.each(data, function(key_parent, val_parent){       
                if(key_parent=='regions'){
                     $.each(val_parent, function(key, val){    
                          //First create the li
                        var div_id='div_region_'+key;                
                        var div_iframe='<div style="display:none; border:1px dotted #CCC" class="region_iframe" id="div_iframe_region_'+key+'"><iframe rel="'+key+'" id="iframe_region_'+key+'" src="" width="100%" onLoad="autoResize(this)" height="30px" /></div>';
                        var div_check_all='<div class="extra_block_buttons_wrap"><div  class="extra_block_buttons" ><div style="padding:0.4em 0.8em; margin:0.2em 0 0.5em 0" onClick="changeCheckAllDiv(this);"  class="check-all-zone button" ><input onClick="changeCheckAll(this);" type="checkbox" name="check-all" class="check-all-button" value=""></div></div><div class="extra_block_buttons" ><input type="button" onClick="doActive('+key+');" class="button" value="<?php echo t('Active'); ?>" />&nbsp;<input type="button" onClick="doDisable('+key+');" class="button" value="<?php echo t('Disable'); ?>" />&nbsp;<input type="button" onClick="doDelete('+key+');" class="button" value="<?php echo t('Delete'); ?>" /></div><div style="clear:both"></div></div>';
                        var ul_html='<ul class="ul_region" id="ul_region_'+key+'"></ul>';                        
                        var div_string='<div class="div_regions" id="'+div_id+'">'+div_check_all+ul_html+div_iframe+'</div>';
                        var li_string='<li><a rel="'+div_id+'" href="javascript:void(0);">'+val+'</a></li>';                
                        $('#page-regions-list').append(li_string);
                        $('#page-regions-wrapper').append(div_string);
                     });
                } 
                
                if(key_parent=='layout') {
                    $('#layout_select').val(val_parent);
                }
                
                  if(key_parent=='types'){
                     $('#display_type_option').empty();
                     $.each(val_parent, function(key, val){    
                           var select='<option value="'+val+'">'+val+'</option>';
                           $('#display_type_option').append(select);
                     });
                     
                     //From here, we will check the current select display type from the model
                     
                     var current_display_type= '<?php echo (isset($model->display_type) && $model->display_type!=null) ? $model->display_type : 'main'; ?>';
                     $('#display_type_option').val(current_display_type);
                  }
             
               
                
         });                  
          
         
         //Hide all Regions
         $(".div_regions").hide();
         
         //Init the first tab to be current
         $('#page-regions-list a:first').addClass('tab-current');
         $('.div_regions:first').show();
         
         $('#page-regions-list a').click(function(){             
               $('#page-regions-list a').removeClass('tab-current');
               $(this).addClass('tab-current');
               $(".div_regions").hide();                              
               $('div#'+$(this).attr('rel')).show();                
         });
        
         
         $('.ul_region').sortable();
         

    }
    
    function initBlocks(){
        
           <?php 
                if (is_array($regions_blocks) && !empty($regions_blocks) > 0)  : ?>
                    //Start to get the content based on the ids
            <?php                           
                    
            
                    foreach($regions_blocks as $key=>$obj_blocks){
                        $blocks=array();                                            
                        for($i=0;$i<count($obj_blocks['id']);$i++){
                            $obj_block=$obj_blocks['id'][$i];
                            $temp_block=Block::model()->findByPk($obj_block);
                            if($temp_block){
                                $count=$i+1;
                                $blocks['item_'.$count.'_'.$temp_block->block_id]['region']=$key;
                                $blocks['item_'.$count.'_'.$temp_block->block_id]['id']=$temp_block->block_id;
                                $blocks['item_'.$count.'_'.$temp_block->block_id]['title']=$temp_block->name;
                                $blocks['item_'.$count.'_'.$temp_block->block_id]['status']=$obj_blocks['status'][$i];
                            }
                            
                        }
                        
                        
                        echo 'var block_list_region_'.$key.' = '.json_encode($blocks).';'; 
                        
                        echo '$.each(block_list_region_'.$key.', function(k,v) { 
                             
                             setBlocksForRegion(v.region,v.title,v.id,v.status);              
                        });' ;

                       
                    }

                   
            ?>
                    
            <?php endif; ?> 
    }
    $(document).ready(function() {
            getRegionsByLayouts();
            

            $('#layout_select').change(function() {                 
                    getRegionsByLayouts();
            });

           
            <?php if($model->isNewRecord) : ?>    
                CopyString('#Page_name','#Page_title','');
                CopyString('#Page_name','#Page_slug','slug');    
            <?php endif; ?>
                
                         
     });
</script>
