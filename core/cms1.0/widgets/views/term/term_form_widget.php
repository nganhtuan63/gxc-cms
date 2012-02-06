<?php if ((Yii::app()->user->hasFlash('success')) && (isset($_GET['embed'])) ) : ?>
    <script type="text/javascript">
         window.parent.closeIframe();
         window.parent.updateItemName(window.parent.document.getElementById(window.name),
         '<?php echo CHtml::encode($model->name.' - '.$model->description); ?>','<?php echo $model->term_id ?>',
         '<?php echo $model->parent ?>');
    </script>
<?php endif; ?>

<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'term-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>

        <?php $get_taxonomy_id = isset($_GET['taxonomy']) ? (int)($_GET['taxonomy']) : null  ?>
        
        <?php if($get_taxonomy_id===null) : ?>
            <div class="row">   
                <?php echo $form->labelEx($model,'taxonomy_id'); ?>	        
                <?php echo $form->dropDownList($model,'taxonomy_id',  Taxonomy::getTaxonomy(),                
                        array(
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>  Yii::app()->controller->createUrl('dynamicParentTerms'),                                        
                            'update'=>'#parent_id',                       
                            //'data'=>'js:javascript statement' 
                            //leave out the data key to pass all form values through
                            ))
                    ); ?>
                <?php echo $form->error($model,'taxonomy_id'); ?>
            </div>
        <?php else : ?>
            <?php  echo $form->hiddenField($model,'taxonomy_id',array('value'=>$get_taxonomy_id)); ?>
        <?php endif; ?>


        <?php $get_parent_id = isset($_GET['parent']) ? (int)($_GET['parent']) : null  ?>
        
        <?php if($get_parent_id===null) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'parent'); ?>	 
                <?php if($model->isNewRecord) : ?>
                    <?php echo $form->dropDownList($model,'parent',array("0"=>t("None")),array('id'=>'parent_id')); ?>
                <?php else :?>
                    <?php echo $form->dropDownList($model,'parent',Term::getTermFromTaxonomy($model->taxonomy_id,false),array('id'=>'parent_id','options' => array($model->parent=>array('selected'=>true)))); ?>
                <?php endif; ?>
                <?php echo $form->error($model,'parent'); ?>
            </div>
         <?php else : ?>
            <?php  echo $form->hiddenField($model,'parent',array('value'=>$get_parent_id)); ?>
         <?php endif; ?>
    
<div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'slug'); ?>
        <?php echo $form->textField($model,'slug'); ?>
        <?php echo $form->error($model,'slug'); ?>
</div>
<div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
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
<?php if($model->isNewRecord) : ?>
<script type="text/javascript">
CopyString('#Term_name','#Term_slug','slug');
</script>
<?php endif; ?>