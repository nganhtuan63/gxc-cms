<div style="margin:0 50px;"><h1><?php echo t('Chia sẻ bài học'); ?></h1></div>  

<?php    
        $cs=Yii::app()->clientScript;
		$cs->registerScriptFile( $this->layout_asset.'/js/MarkDown.Converter.js');
		$cs->registerScriptFile( $this->layout_asset.'/js/MarkDown.Sanitizer.js');
		$cs->registerScriptFile( $this->layout_asset.'/js/MarkDown.Editor.js');
		$cs->registerScriptFile( $this->layout_asset.'/js/bootstrap-modal.js');
?>   

<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="successMessage alert-message block-message success notification" style='margin:0 50px; margin-bottom:10px'>
<div>
 <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
</div>
<script type="text/javascript" >
      //$(".notification").delay(2100).fadeOut(1300);
</script>
<?php endif; ?>


<?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'lesson-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),     
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            )); 
        ?>
 <?php echo $form->errorSummary($model,'Có lỗi xảy ra',null,array('class'=>'alert-message block-message error','style'=>'margin:0 50px; margin-bottom:10px')); ?>
<div class="form-stacked" style="background: #EEE;border: 1px solid #DDD; margin:0 50px; padding-left:0px">
  
        
        
       
        
        <div id="share_rules" style="padding-left:20px">
	      <h4>Bạn nên biết</h4>
	      <ul>
	        <li>Chỉ chia sẻ nội dung liên quan đến kiến thức có ích cho mọi người.</li>
	        <li>Không được đăng các bài liên quan đến chính trị, các bài không phù hợp với văn hoá Việt nam.</li>
	        <li>Sử dụng công cụ tìm kiếm trước để tránh chủ đề bị lặp nhiều lần</li>	        
	        <li><a href="/contact">Liên hệ với chúng tôi</a> nếu bạn có bất kỳ thắc mắc gì.</li>
	      </ul>
	    </div>
	    
	 
     	<div style="padding:10px 0 10px 20px">
     		<h4>Thông tin chung</h4>
     		 <div  class="clearfix">
              <label>Định dạng</label>
                <div class="input">
              <?php echo $form->dropDownList($model,'format',HmnConstantDefine::getLessonTypes(),array('onChange'=>'changeType()','id'=>'type_select')); ?>              
              <?php echo $form->error($model,'format',array()); ?>
              </div>
        </div>
       
     	<div  class="clearfix">
             <label>Tiêu đề</label>
                <div class="input">
              <?php echo $form->textField($model,'name',array('class'=>'span8')); ?>              
              <?php echo $form->error($model,'name',array()); ?>
              </div>
        </div>
         <div  class="clearfix" id="link_youtube">
             	<label>Link Youtube</label>
                <div class="input" >
              <?php echo $form->textField($model,'link_youtube',array('class'=>'span8')); ?>              
              <?php echo $form->error($model,'link_youtube',array()); ?>
              </div>
             </div>
      
       
        </div>
        
        <div style="padding:10px 0 10px 20px; border-top:1px dashed #CCC">        	
        	<h4>Chi tiết</h4>
        		 <div  class="clearfix">
              <label>Danh mục</label>
                <div class="input">
              <?php echo $form->dropDownList($model,'cat',HmnConstantDefine::getLessonTerms(),array()); ?>              
              <?php echo $form->error($model,'cat',array()); ?>
              </div>
             </div>
        	  
              <div  class="clearfix">
             	<label>Nội dung</label>
             	
                <div class="input">
                	<div id="wmd-button-bar" class="wmd-panel"></div>
      
              <?php echo $form->textArea($model,'content',array('autoComplete'=>'off','rows'=>'10','class'=>'xxlarge span13  wmd-panel')); ?>              
              <?php echo $form->error($model,'content',array()); ?>
              <div id="wmd-preview" class="wmd-panel span13"></div>
              <div id="wmd-output" class="wmd-panel"></div>	
              </div>
        		</div>
        		
        		 
        		
        		
              
        </div>
       	
       	<div style="padding:10px 0 10px 20px; border-top:1px dashed #CCC">
       		<h4>Thông tin khác</h4>
	       		<div  class="clearfix">
	             	<label>Ảnh đại diện</label>
	                <div class="input">
	                	
	                	<div id="thumb_wrapper" class="pop_image_small" style="height:auto;padding:0; margin:5px 0; float:none; background: none"><a href="javascript:void(0);" class="image_link" title=""><img id="thumb" alt="" class="search_thumbnail" width="120" height="90" src="<?php echo ($model->image!='') ? $model->image : $this->layout_asset.'/images/dummy.gif'; ?>"></a></div>
	                	
	                	<?php echo $form->hiddenField($model,'image'); ?>
	                	<?php echo $form->error($model,'image',array()); ?>
	           			<button data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true" class="btn">Đổi ảnh</button>
	           		</div>
	           		
	           		<div id="modal-from-dom" class="modal hide fade in" style="display: none; ">
		            <div class="modal-header">
		              <a href="javascript:void(0);" class="close">×</a>
		              <h3>Upload ảnh</h3>
		            </div>
		            <div class="modal-body">
		              <iframe src="<?php echo bu();?>/upload-image" width="100%" height="220"></iframe>
		            </div>
		            <div class="modal-footer">		              
		            </div>
		          </div>
	          </div>
	          
	            <div  class="clearfix">
             	<label>Nguồn tham khảo</label>
                <div class="input">
              <?php echo $form->textField($model,'source',array()); ?>              
              <?php echo $form->error($model,'source',array()); ?>
              </div>
             </div>
             
	          <div  class="clearfix">
	             	<label>Hoàn chỉnh?</label>
	                <div class="input">
	           		<?php echo $form->radioButtonList(
					  $model, 'finish', 
					 HmnConstantDefine::getLessonFinish(),
					  array('separator'=>'&nbsp;&nbsp;','template'=>'{input} {label}','labelOptions'=>array('style'=>'display:inline; font-weight:normal'))
					); ?>
	           		</div>
	          </div>
	          
	            
                      
       	</div>
        <div style="padding:10px 0 10px 20px">
       
        <div class="actions">
            <?php echo CHtml::submitButton(t('Gởi'),array('class'=>'btn primary','id'=>'bUpdate')); ?>
        </div>
        
   		</div>
   		  <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">

	$().ready(function() {
		    var converter1 = Markdown.getSanitizingConverter();
            var editor1 = new Markdown.Editor(converter1,'',null,'ShareLessonForm_content');
            editor1.run();
		});
	function changeType(){
		if($('#type_select').val()==<?php echo HmnConstantDefine::LESSON_YOUTUBE ; ?>){
			$('#link_youtube').show();
		} else {
			$('#link_youtube').hide();
		}
	}
	
	function setThumbImage(src){
		if(src!=''){
			$('#thumb_wrapper').show();
			$('#thumb').attr('src',src);
			$('#ShareLessonForm_image').val(src);
		} else {			
			$('#thumb').attr('src','');
			$('#thumb_wrapper').hide();
			$('#ShareLessonForm_image').val('');
		}
		
	}
	
	
	function afterUploadFromIframe(src){		
		$('#modal-from-dom').modal('hide');		
		setThumbImage(src);
		$('#thumb_wrapper').show();
	}
	var current_type=<?php echo isset($model->format) ? $model->format : HmnConstantDefine::LESSON_YOUTUBE; ?>;
	changeType();
	
	<?php 
		if($model->image=='') :
	?>
	
	$('#thumb_wrapper').hide();
	<?php endif; ?>
	
	$("#ShareLessonForm_link_youtube").keyup(function() {
	    setThumbImage($.jYoutube($(this).val(), 'default'));
					   
	});
	$("#ShareLessonForm_link_youtube").change(function() {
    	setThumbImage($.jYoutube($(this).val(), 'default'));   
	});
				
	

</script>
