<?php
$this->pageTitle='Test a fetch';
$this->pageHint='Please fill in the Brand Page and Basic info to test';

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brand-form',
	'enableAjaxValidation'=>false,
)); ?>     

    <?php echo $form->errorSummary($modelProductFetch); ?>
    <div class="row">
   
    <div class="left">
         <h4>Site Basic Info</h4>    
        <?php echo CHtml::label('Brand Name',''); ;?>
        <?php echo CHtml::textField('brand',$params['brand']); ;?>
        <?php echo CHtml::label('Site URL',''); ;?>
        <?php echo CHtml::textField('site_url',$params['site_url']); ;?>
        <?php echo CHtml::label('Page URL',''); ;?>
        <?php echo CHtml::textField('page_url',$params['page_url']); ;?>
        <?php echo CHtml::label('Paging Number',''); ;?>
        <?php echo CHtml::textField('current_page',$params['current_page']); ;?>
    </div>
    
    <div class="left" style="margin-left:15px">        
        <h4>Product Fetch HTML</h4>
        <?php echo $form->labelEx($modelProductFetch,'pf_wrapper',array()); ?>
        <?php echo $form->textField($modelProductFetch,'pf_wrapper',array()); ?>             
        <?php echo $form->labelEx($modelProductFetch,'pf_onsite_product_id',array()); ?>
        <?php echo $form->textField($modelProductFetch,'pf_onsite_product_id',array()); ?>               
        <?php echo $form->labelEx($modelProductFetch,'pf_template',array()); ?>
        <?php echo $form->textArea($modelProductFetch,'pf_template',array('rows'=>9)); ?>   
        <?php echo $form->labelEx($modelProductFetch,'pf_paging_wrap',array()); ?>
        <?php echo $form->textField($modelProductFetch,'pf_paging_wrap',array()); ?>        
        
       
    </div>
    <div class="clear"></div>
    </div>
    <?php if($result!=''): ?>
    <h4>Results </h4>
    <div class="row">
        
        <?php echo $result; // echo CHtml::textArea('result_area',$result,array('style'=>'height:400px;')); ?>        
    </div>
    <?php endif; ?>
	<div class="row">
		<?php echo CHtml::submitButton('Excute', array('class'=>'button')); ?>
        <div class="clear"></div> 
	</div>
    
    
<?php $this->endWidget(); ?>

</div><!-- form -->