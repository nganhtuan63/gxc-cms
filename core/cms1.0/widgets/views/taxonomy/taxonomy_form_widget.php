<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'taxonomy-form',
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
<?php if($model->isNewRecord && $type=='') : ?>
<div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type', GxcHelpers::getAvailableContentType(true)); ?>
        <?php echo $form->error($model,'type'); ?>
</div>    
<?php else: ?>
        <?php echo $form->hiddenField($model,'type',array('value'=>$type)); ?>
<?php endif; ?>
<div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
</div>

<?php if (!$model->isNewRecord) : ?>
<div class="row"> 
<?php $this->widget('cmswidgets.TreeFormWidget',array('title'=>t('Terms'),    
    'form_create_url'=>$this->form_create_term_url,
    'form_update_url'=>$this->form_update_term_url,
    'form_change_order_url'=>$this->form_change_order_term_url,
    'form_delete_url'=>$this->form_delete_term_url,    
    'list_items'=>isset($list_items) ? $list_items : array()
    )); ?>
</div>
<?php endif; ?>  
    
       
<div class="row buttons">
        <?php echo CHtml::submitButton(t('Save'),array('class'=>'bebutton')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
