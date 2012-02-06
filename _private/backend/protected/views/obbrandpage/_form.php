<?php if ((Yii::app()->user->hasFlash('success')) && (isset($_GET['embed'])) ) : ?>
    <script type="text/javascript">
         window.parent.closeIframe();
         window.parent.updateItemName(window.parent.document.getElementById(window.name),
         '<?php echo CHtml::encode($model->bp_description); ?>','<?php echo $model->bp_id ?>',
         '<?php echo $model->parent ?>');
    </script>
<?php endif; ?>

<div class="form">
<?php $this->renderPartial('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'brandpage-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>

        <?php $get_brand_id = isset($_GET['brand']) ? (int)($_GET['brand']) : null  ?>
        
        <?php if($get_brand_id===null) : ?>
            <div class="row">   
                <?php echo $form->labelEx($model,'bp_brand_id'); ?>	        
                <?php echo $form->dropDownList($model,'bp_brand_id', Brand::getBrand()
                    ); ?>
                <?php echo $form->error($model,'bp_brand_id'); ?>
            </div>
        <?php else : ?>
            <?php  echo $form->hiddenField($model,'bp_brand_id',array('value'=>$get_brand_id)); ?>
        <?php endif; ?>


        
        <?php $get_parent_id = isset($_GET['parent']) ? (int)($_GET['parent']) : null  ?>
        
        <?php if($get_parent_id===null) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'parent'); ?>	 
                <?php if($model->isNewRecord) : ?>
                    <?php echo $form->dropDownList($model,'parent',array("0"=>t("None")),array('id'=>'parent_id')); ?>
                <?php else :?>
                    <?php echo $form->dropDownList($model,'parent', BrandPage::getBrandPageFromBrand($model->bp_brand_id,false),array('id'=>'parent_id','options' => array($model->parent=>array('selected'=>true)))); ?>
                <?php endif; ?>
                <?php echo $form->error($model,'parent'); ?>
            </div>
         <?php else : ?>
            <?php  echo $form->hiddenField($model,'parent',array('value'=>$get_parent_id)); ?>
         <?php endif; ?>
    
    
<div class="row">
       
</div>
<div class="row">    
    <div>
         <?php echo $form->labelEx($model,'bp_term_id',array('class'=>'labelInline')); ?>      
         <?php /* $this->widget('CAutoComplete', array(
                    'mustMatch'=>true,
                    'name'=>'bp_name',
                    'url'=>array('suggestName'),
                    'value'=> Term::getTermName($model->bp_term_id),
                    'multipleSeparator'=>';',
                    'extraParams'=>array('parent'=>$get_parent_id),                    
                    'multiple'=>false,
                    'htmlOptions'=>array('size'=>50,'class'=>'maxWidthInput','id'=>'bp_name'),            
                    'methodChain'=>".result(function(event,item){ if(item!==undefined) \$(\"#term_id\").val(item[1]); })",
                )); */?>                   
        <?php //echo $form->hiddenField($model,'bp_term_id',array('id'=>'term_id')); ?>
       
      
        <?php 
        	//Get the Terms based on current parent_id;
        			if($get_parent_id){
        				 $bp_parent=BrandPage::model()->findByPk($get_parent_id);
		                //Get the parent term
		                if($bp_parent){
		                    $bp_term_parent_id=$bp_parent->bp_term_id;
		                } else {
		                	 $bp_term_parent_id=0;
		                }
        			} else {
        				$bp_term_parent_id=0;
        			}
	        	   
					echo CHtml::activeRadioButtonList(
							  $model, 'bp_term_id', 
							  CHtml::listData(Term::model()->findAll('parent=:parent_id',array(':parent_id'=>$bp_term_parent_id)), 'term_id', 'name'),
							  array('onClick'=>'return CloneLabelToDescription(this);','template'=>'<div style="float:left; margin-right:20px;" class="row_radio">{input} {label}</div>','separator'=>'&nbsp;')
							);;
			
        ?>
        <script type="text/javascript">
        	function CloneLabelToDescription(object){
        		$('#BrandPage_bp_description').val($(object).next().html());
        	}
        </script>
        <div class="clear"></div>
         <?php echo $form->error($model,'bp_term_id'); ?>
    </div>
    <div class="left"  style="">
        <?php echo $form->labelEx($model,'bp_url'); ?>
        <?php echo $form->textField($model,'bp_url'); ?>
        <?php echo $form->error($model,'bp_url'); ?>
    </div>
    <div class="left" style="margin-left:15px">
        <?php echo $form->labelEx($model,'bp_description'); ?>
        <?php echo $form->textField($model,'bp_description'); ?>
        <?php echo $form->error($model,'bp_description'); ?>
    </div>
        <div class="clear"></div>
</div>
<div class="row">
    <div class="left">
        <?php echo $form->labelEx($model,'bp_active',array('style'=>'display:inline')); ?>
        <?php echo $form->checkBox($model,'bp_active',array()); ?><br/>
    </div>
    <div class="left" style="margin-left:15px;">
        <?php echo $form->labelEx($model,'bp_allow_parse',array('style'=>'display:inline')); ?>
        <?php echo $form->checkBox($model,'bp_allow_parse',array()); ?><br/>
    </div>
    <div class="left" style="margin-left:15px;">
        <?php echo $form->labelEx($model,'bp_allow_crawl',array('style'=>'display:inline')); ?>
        <?php echo $form->checkBox($model,'bp_allow_crawl',array()); ?><br/>
    </div>
    <div class="clear"></div>
</div>
<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'button')); ?>
    
        <?php if(isset($_GET['embed'])) : ?>
            <?php if($model->isNewRecord) : ?>
                <input type="button" class="button" onClick="window.parent.cancelOnCreate(window.parent.document.getElementById(window.name));" value="Cancel" />
            <?php else : ?>
                <input type="button" class="button" onClick="window.parent.cancelOnUpdate(window.parent.document.getElementById(window.name));" value="Cancel" />
            <?php endif; ?>
        <?php endif; ?>
    
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
