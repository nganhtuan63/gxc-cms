<?php if ((Yii::app()->user->hasFlash('success')) && (isset($_GET['embed'])) ) : ?>
    <script type="text/javascript">
         window.parent.closeIframeFetch();
         window.parent.setFetchList('<?php echo 'Fetch Id - '.CHtml::encode($model->pf_id); ?>','<?php echo $model->pf_id ?>');
    </script>
<?php endif; ?>

<div class="form">
<?php $this->renderPartial('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fetch-form',
	'enableAjaxValidation'=>true,
)); ?>     
   
    <div class="row">        
        
        <?php $get_brand_id = isset($_GET['brand']) ? (int)($_GET['brand']) : null  ?>
        
        <?php if($get_brand_id===null) : ?>
            <div class="row">   
                <?php echo $form->labelEx($model,'pf_brand_id'); ?>	        
                <?php echo $form->dropDownList($model,'pf_brand_id',  Brand::getBrand()               
                       
                    ); ?>
                <?php echo $form->error($model,'pf_brand_id'); ?>
            </div>
        <?php else : ?>
            <?php  echo $form->hiddenField($model,'pf_brand_id',array('value'=>$get_brand_id)); ?>
        <?php endif; ?>
    </div>    
          
    <div class="row">
        <?php echo $form->labelEx($model,'pf_wrapper',array()); ?>
        <?php echo $form->textField($model,'pf_wrapper',array()); ?>  
        <?php echo $form->error($model,'pf_wrapper'); ?>
    </div>
    
    <div class="row">        
        <?php echo $form->labelEx($model,'pf_onsite_product_id',array()); ?>
        <?php echo $form->textField($model,'pf_onsite_product_id',array()); ?> 
         <?php echo $form->error($model,'pf_onsite_product_id'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'pf_brand',array()); ?>
        <?php echo $form->textField($model,'pf_brand',array()); ?> 
        <?php echo $form->error($model,'pf_brand'); ?>
        
    </div>
    
    <div class="row">
        
        <?php echo $form->labelEx($model,'pf_paging_wrap',array()); ?>
        <?php echo $form->textField($model,'pf_paging_wrap',array()); ?>  
        <?php echo $form->error($model,'pf_paging_wrap'); ?>
        
    </div>
    
     <div class="row">        
        <?php echo $form->labelEx($model,'pf_html_detail_id',array()); ?>
        <?php echo $form->textField($model,'pf_html_detail_id',array()); ?> 
         <?php echo $form->error($model,'pf_html_detail_id'); ?>
    </div>
    
    
    <div class="row">
        
        <?php echo $form->labelEx($model,'pf_template',array()); ?>
        <?php echo $form->textArea($model,'pf_template',array('rows'=>9)); ?>   
        <?php echo $form->error($model,'pf_template'); ?>
      
    </div>   
     <div class="row">
        
        <?php echo $form->labelEx($model,'expired',array()); ?>
        <?php echo $form->textField($model,'expired',array('rows'=>9)); ?>   
        <?php echo $form->error($model,'expired'); ?>
      
    </div>  
        <div class="clear"></div> 
    </div>
    
  
	<div class="row  buttons ">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
            
              <?php if(isset($_GET['embed'])): ?>
                <input type="button" class="button" value="<?php echo t('Cancel');?>" onClick="window.parent.closeIframeFetch();"/>
                <?php endif; ?>
            
            
        <div class="clear"></div> 
	</div>
    
    
<?php $this->endWidget(); ?>