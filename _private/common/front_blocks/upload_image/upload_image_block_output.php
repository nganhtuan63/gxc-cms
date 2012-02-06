<?php
 if($img) :
?>
<script type="text/javascript">
	window.parent.afterUploadFromIframe('<?php echo $img;?>');
	
</script>
<?php endif; ?>
<div class="form-stacked">
  		
        <?php $this->render('cmswidgets.views.notification_frontend'); ?>
         
         <ul class="pills" style="margin:0px" id="upload-pills">
        <li class="active" id="from_computer"><a href="javascript:void(0);"  onClick="return switchUpload('computer','web');">Từ máy tính</a></li>
        <li id="from_web"><a href="javascript:void(0);" onClick="return switchUpload('web','computer');">Đường dẫn web</a></li>      
      </ul>
      
        <?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'image-form',            
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,                
            ),
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            )); 
        ?>
       
        <div class="clearfix" id="computer">                         	 
           <img src="http://i.imgur.com/GKc7H.png" height="15px" width="15px" style="vertical-align:middle;margin-right:6px;"><?php echo $form->fileField($model,'image',array('style'=>'margin-top:15px;background:transparent')); ?>           
        	<?php echo $form->error($model,'image',array('style'=>'')); ?>
        </div>         	
           <div class="clearfix" id="web" style="display:none">
           	<?php echo $form->textField($model,'image_url',array('style'=>'margin-top:15px')); ?>
           	<?php echo $form->error($model,'image_url',array('style'=>'')); ?>
           	</div>                       
        
        
        
         
        <?php echo CHtml::submitButton(t('Upload'),array('class'=>'btn','id'=>'bUpload')); ?>                      
          <?php $this->endWidget(); ?>    
          
          <div id="loading" style="display:none">
          <img  src="<?php echo $this->layout_asset;?>/images/ajax-loader.gif" />
          </div>
          <script type="text/javascript">
          
	           $('#image-form').submit(function() {
				  $('#loading').show();				 
				});
          		function switchUpload(type1,type2){
          			$('#'+type2).hide();
          			$('#'+type1).show();
          			$('#from_'+type2).removeClass('active');
          			$('#from_'+type1).addClass('active');          			
          		}
          		
          </script> 
    
    		
    	<?php if($img) : ?>
    		
			
    	<div class="clearfix" id="showUrl">
    		<input type="text" value="<?php echo $img; ?>" id="imgur" />
    	</div>
    	
    	<script type="text/javascript">
    		
    		function selectAllText(textbox) {
			    textbox.focus();
			    textbox.select();
			}
			$('#imgur').click(function() { selectAllText(jQuery(this)) });
			</script>
    	<?php endif; ?>
</div>