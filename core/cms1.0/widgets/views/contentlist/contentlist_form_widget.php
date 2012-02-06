<?php if ((Yii::app()->user->hasFlash('success')) && (isset($_GET['embed'])) ) : ?>
    <script type="text/javascript">
         window.parent.resetIframe();
         window.parent.addContentList(
         '<?php echo CHtml::encode($model->name); ?>','<?php echo $model->content_list_id ?>');
    </script>
<?php endif; ?>
    
<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contentlist-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>
<div class="row">
    
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'name'); ?>
        <div class="clear"></div>
</div>

<div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type',  ConstantDefine::getContentListType(),array('id'=>'queue-type')); ?>
        <?php echo $form->error($model,'type'); ?>
        <div class="clear"></div>
</div>
<div id="params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_MANUAL; ?>" style="display:none">
<div class="content-box ">
        <div class="content-box-header">
        <h3><?php echo t('Params');?></h3>                                
        </div> 

        <div class="content-box-content" style="display: block; padding: 0 0 15px 0">
                <div class="tab-content default-tab">
                         <div class="row">
                                <div style="padding:15px">
                                <?php echo CHtml::label(t('Add content'),''); ?>
                                <?php $this->widget('CAutoComplete', array(
                                'mustMatch'=>true,
                                'name'=>'manual_list_name',
                                'url'=>array('suggestContent'),
                                'multipleSeparator'=>';',
                                'value'=>'',
                                'multiple'=>false,
                                'htmlOptions'=>array('size'=>50,'class'=>'maxWidthInput','id'=>'form_content_list'),
                                'methodChain'=>".result(function(event,item){ if(item !== undefined )  setContentList(item[0],item[1]); \$(\"#form_content_list\").val('');})",
                                )); ?>

                                <span id="current_content_list_count" style="display:none">0</span>
                                
                                 <div class="clear"></div>
                                </div>
                                <ul id="content_list_manual">
                                    
                                </ul>
                               
                                
                                <script type="text/javascript">
                                    <?php 
                                        if (is_array($model->manual_list) && !empty($model->manual_list) > 0)  : ?>
                                            //Start to get the content based on the ids
                                    <?php       
                                            $content_items=array();
                                            foreach($model->manual_list as $obj_id){
                                                $temp_object=Object::model()->findByPk($obj_id);
                                                if($temp_object){
                                                    $content_items['item_'.$temp_object->object_id]['id']=$temp_object->object_id;
                                                    $content_items['item_'.$temp_object->object_id]['title']=$temp_object->object_name;
                                                }
                                            }

                                            echo 'var manual_content_list = '.json_encode($content_items).';'; 
                                    ?>
                                            $.each(manual_content_list, function(k,v) {                        
                                                     setContentList(v.title,v.id);              
                                            }); 
                                            
                                    <?php endif; ?>
                                    function setContentList(linkTitle,linkId){       
                                        //Update the number for the Upload Count;
                                        var current_count=$('#current_content_list_count').html();
                                        current_count=parseInt(current_count);
                                        current_count++;
                                        $('#current_content_list_count').html(current_count.toString());
                                        var nextli='list_id_content_list_'+linkId;
                                        var li='<li id=\"'+nextli+'\"><input type=\"hidden\" name=\"content_list_title[]\" id=\"input_title_'+nextli+'\" value=\"'+linkTitle+'\" /><input type=\"hidden\" name=\"content_list_id[]\" id=\"input_id_'+nextli+'\" value=\"'+linkId+'\" /><a href=\"<?php echo Yii::app()->controller->createUrl($this->object_update_url); ?>/'+linkId+'\" target="_blank">'+linkTitle+'</a> - <a href=\"javascript:void(0);\" onClick=\"deleteContentList(\''+nextli+'\');\">Delete</a></li>';        
                                        $('#content_list_manual').append(li);
                                        return;

                                    }
                                    
                                    function deleteContentList(id){
                                         var current_count=$('#current_content_list_count').html();
                                         current_count=parseInt(current_count);
                                         current_count--;
                                         if(current_count<0) current_count=0;
                                         $("#"+id).remove();
                                         $('#current_content_list_count').html(current_count.toString());
                                    }
                                    
                                    $('#content_list_manual').sortable();
                                  
                                </script>
                        </div>
                </div>                                                
        </div>
</div>

       

</div>
<div id="params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_AUTO; ?>" style="display:none">
    
<div class="closed-box content-box ">
        <div class="content-box-header">
        <h3><?php echo t('Params');?></h3>                                
        </div> 
        <div class="content-box-content" style="display: block;">
                <div class="tab-content default-tab">
                        <div class="row">

                            <?php echo $form->labelEx($model,'criteria'); ?>
                            <?php echo $form->dropDownList($model,'criteria',  ConstantDefine::getContentListCriteria(),array('style'=>'width:100px')); ?>
                            <?php echo $form->error($model,'criteria'); ?>
                            <div>
                            <div class="left">
                              <?php echo $form->labelEx($model,'lang'); ?>
                              <?php echo $form->listBox($model,'lang',
                                                                ContentList::getContentLang(),
                                                                array(                                   
                                                                     'multiple'=>'multiple','style'=>'width:150px; height:70px','class'=>'listbox','id'=>'content_lang_box')
                                                        ); ?>
                              <?php echo $form->error($model,'lang'); ?>
                            </div>
                            <div class="left" style="margin-left:20px">
                                <?php echo $form->labelEx($model,'content_type'); ?>
                                <?php echo $form->listBox($model,'content_type', 
                                                                ContentList::getContentType(), 
                                                                array( 
                                                                     'multiple'=>'multiple','style'=>'width:250px; height:70px','class'=>'listbox','id'=>'content_type_box')
                                                        ); ?>
                                <script>
                                        $(document).ready(function () {
                                            $('#content_type_box').change(function() {                          				
                                                changeTerms();                                    
                                            });

                                            $('#content_lang_box').change(function() {

                                                changeTerms();                                    
                                            });




                                        });
                                        function changeTerms(){
                                                  <?php echo CHtml::ajax(array(                            
                                                    'url'=>array('dynamicTerms'),                             
                                                    'data'=>array('q'=>'js:$(\'#content_type_box\').val()', 
                                                                  'lang'=>'js:$(\'#content_lang_box\').val()', 
                                                                  'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                                                                    ),
                                                    'type'=>'post',
                                                    'dataType'=>'html',
                                                    'success'=>"function(data)
                                                    {
                                                        $('#term_id').empty();
                                                        $('#term_id').append(data);

                                                    } ",
                                                    ));?>
                                            }

                                </script>
                                <?php echo $form->error($model,'content_type'); ?>
                            </div>
                            <div class="left" style="margin-left:20px">
                            <?php echo $form->labelEx($model,'terms'); ?>
                            <?php echo $form->listBox($model,'terms', ContentList::getTerms(),
                                    array(
                                     'id'=>'term_id','multiple'=>'multiple','style'=>'width:250px; height:100px','class'=>'listbox')); ?>
                            <?php echo $form->error($model,'terms'); ?>
                            </div>
                            <div class="left">
                            <?php echo $form->labelEx($model,'tags'); ?>
                            <?php $this->widget('CAutoComplete', array(
                                    'model'=>$model,
                                    'mustMatch'=>true,
                                    'attribute'=>'tags',
                                    'url'=>array('suggestTags'),
                                    'multiple'=>true,
                                    'htmlOptions'=>array('size'=>50,'style'=>'width:300px'),
                            )); ?>

                            <?php echo $form->error($model,'tags'); ?>
                            </div>
                            <div class="clear"></div>
                            </div>


                            <div>
                            <div class="left">
                            <?php echo $form->labelEx($model,'number'); ?>
                            <?php echo $form->textField($model,'number',array('value'=>$model->isNewRecord ? '10' : $model->number ,'size'=>20,'maxlength'=>20,'style'=>'width:100px')); ?>
                            <?php echo $form->error($model,'number'); ?>
                            </div>
                            <div class="left" style="margin-left:20px">
                            <?php echo $form->labelEx($model,'paging'); ?>
                            <?php echo $form->textField($model,'paging',array('value'=>$model->isNewRecord ? '0' : $model->paging ,'size'=>20,'maxlength'=>20,'style'=>'width:100px')); ?>
                            <?php echo $form->error($model,'paging'); ?>
                            </div>
                            <div class="clear"></div>
                            </div>

                            <div class="clear"></div>
                            </div>
                </div>                                                
        </div>
</div>
    
        
</div>
	
	<?php if(isset($_GET['type'])) : ?>
	<div class="row">
        <?php echo CHtml::submitButton(isset($_GET['action']) ? t('Save') : t('Add'), array('class'=>'button')); ?>
	</div>
	<?php else : ?>
	<div class="row">
		<?php echo CHtml::submitButton($model->isNewRecord ? t('Create') : t('Save'), array('class'=>'button')); ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?>

<?php $this->endWidget(); ?>

 <script>
	
        function checkQT(){
         var qtype=$('#queue-type').val();
         
         if(qtype==<?php echo ConstantDefine::CONTENT_LIST_TYPE_AUTO ;?>){
            $('#params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_MANUAL ;?>').hide();
            $('#params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_AUTO ;?>').show();	
            
	    
            if($('#content_type_box').val()==null){                
		$('#content_type_box').val('all');
	    }
            if($('#content_lang_box').val()==null){                
		$('#content_lang_box').val('0');
	    }
	    if($('#term_id').val()==null){
		$('#term_id').val('0');
	    }
            
            changeTerms();
            
         } else {
            $('#params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_AUTO ;?>').hide();
            $('#params-<?php echo ConstantDefine::CONTENT_LIST_TYPE_MANUAL ;?>').show();
         }
        }
        
        checkQT();
        
        $('#queue-type').change(function() { 
	    checkQT();
	});
	
	
        
        
     </script>

</div><!-- form -->