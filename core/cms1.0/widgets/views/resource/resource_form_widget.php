  
<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'resource-form',
        'enableAjaxValidation'=>true,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),       
        )); 
?>

<?php echo $form->errorSummary($model); ?>

        
        	
        <div>
	        <div class="row" style="float:left">
	                <?php echo $form->labelEx($model,'type'); ?>
	                <?php echo $form->dropDownList($model,'type',ConstantDefine::chooseFileTypes(),array('id'=>'chooseFileType')); ?>
	                <?php echo $form->error($model,'type'); ?>                
	        </div>
	        
	        <div class="row" style="float:left; margin-left:20px <?php if(!$is_new) : ?> ; display:none<?php endif; ?>">
	                <?php echo $form->labelEx($model,'where'); ?>
	                <?php 
	                 if($is_new)
	                	echo $form->dropDownList($model,'where',GxcHelpers::getStorages(),array('id'=>'chooseStorage'));
					 else 
	                	echo $form->dropDownList($model,'where',GxcHelpers::getStorages(),array('id'=>'chooseStorage','disabled'=>'disabled'));
	                ?>
	                <?php echo $form->error($model,'where'); ?>                
	        </div>
	        <div class="clear"></div>
       </div>
        <div style="border:2px dotted #CCC; padding:5px <?php if(!$is_new) : ?> ; display:none<?php endif; ?>">
	        <div class="row"  <?php if(!$is_new) : ?> style="display:none"<?php endif; ?>>
	                <?php echo $form->labelEx($model,'upload',array()); ?>
	                <?php
	                if($is_new) 
	                    echo $form->fileField($model,'upload',array('onChange'=>'return fileActive();')) ;
	                else
	                    echo $form->fileField($model,'upload',array('onChange'=>'return fileActive();','disbaled'=>'disabled'));
	                ?>
	                <?php echo $form->error($model,'upload'); ?>
	                <?php echo $form->labelEx($model,'link',array()); ?>
	                <?php
	                if($is_new)
	                    echo $form->textField($model,'link',array('onChange'=>'return linkActive();'));
	                else
	                    echo $form->textField($model,'link',array('onChange'=>'return linkActive();','disabled'=>'disabled')); ?>
	                <?php echo $form->error($model,'link'); ?>
	                 
	        </div>
        </div>
               
        <div class="row">
                <?php echo $form->labelEx($model,'name',array()); ?>
                <?php echo $form->textField($model,'name'); ?>
                <?php echo $form->error($model,'name'); ?>
                
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'body',array()); ?>
                <?php echo $form->textArea($model,'body',array('style'=>'min-height:25px !important')); ?>
                <?php echo $form->error($model,'body'); ?>
                
        </div>
        
  
        <div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
		</div>

<?php $this->endWidget(); ?>  
</div><!-- form -->
 <script type="text/javascript">
    var file_types=<?php echo json_encode($types_array); ?>;
    
    getFileType(getFileExt($("#ResourceUploadForm_upload").val()));
    function getFileExt(filename){
    	return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename).toString().toLowerCase() : undefined;
    }
    
    function getFileType(field){
    	var file_ext=getFileExt($(field).val());
    	var result='file';
    	$.each(file_types, function(key,val){
		    $.each(val, function(key_sub,val_sub){
		    	if(file_ext==val_sub){
		    		result=key;
		    		return false;
		    	} 
		    });
		    		    
		});		
		return result;       
    
    }
    function fileActive(){        
        $("#ResourceUploadForm_link").val('');      
        var current_type=getFileType($("#ResourceUploadForm_upload")).toString();  
        $("#chooseFileType").val(current_type);
        
        //Force to use local default if they choose external when uploading file
        if($('#chooseStorage').val()=='external'){        	
    		$('#chooseStorage').val('local');
    	}
    }
    
    function linkActive(){        
        $("#ResourceUploadForm_upload").val('');
        var current_type=getFileType($("#ResourceUploadForm_link")).toString();
        $("#chooseFileType").val(current_type);        
        // Implement here if this is Image we will keep the Storage
        // If not the Image we will change it to External Storage  
        if(current_type!='image'){
        	if($('#chooseStorage').val()!='external'){
        		$('#chooseStorage').val('external');
        	}        		
        } else {
        	if($('#chooseStorage').val()=='external'){
        		$('#chooseStorage').val('local');
        	}
        }     
    }
</script>