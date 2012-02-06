<?php if ((Yii::app()->user->hasFlash('success')) && (isset($_GET['embed'])) ) : ?>
    <script type="text/javascript">
         window.parent.closeIframe();
         window.parent.updateItemName(window.parent.document.getElementById(window.name),
         '<?php echo CHtml::encode($model->name); ?>','<?php echo $model->menu_item_id ?>',
         '<?php echo $model->parent ?>');
    </script>
<?php endif; ?>

<div class="form">
<?php $this->render('cmswidgets.views.notification'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'menuitem-form',
        'enableAjaxValidation'=>true,       
        )); 
?>

<?php echo $form->errorSummary($model); ?>

        <?php $get_menu_id = isset($_GET['menu']) ? (int)($_GET['menu']) : null  ?>
        
        <?php if($get_menu_id===null) : ?>
            <div class="row">   
                <?php echo $form->labelEx($model,'menu_id'); ?>	        
                <?php echo $form->dropDownList($model,'menu_id',  Menu::getMenu() ,                
                        array(
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>  Yii::app()->controller->createUrl('dynamicParentMenuItem'),                                        
                            'update'=>'#parent_id',                       
                            //'data'=>'js:javascript statement' 
                            //leave out the data key to pass all form values through
                            ))
                    ); ?>
                <?php echo $form->error($model,'menu_id'); ?>
            </div>
        <?php else : ?>
            <?php  echo $form->hiddenField($model,'menu_id',array('value'=>$get_menu_id)); ?>
        <?php endif; ?>


        <?php $get_parent_id = isset($_GET['parent']) ? (int)($_GET['parent']) : null  ?>
        
        <?php if($get_parent_id===null) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'parent'); ?>	 
                <?php if($model->isNewRecord) : ?>
                    <?php echo $form->dropDownList($model,'parent',array("0"=>t("None")),array('id'=>'parent_id')); ?>
                <?php else :?>
                    <?php echo $form->dropDownList($model,'parent',MenuItem::getMenuItemFromMenu($model->menu_id , false),array('id'=>'parent_id','options' => array($model->parent=>array('selected'=>true)))); ?>
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
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
</div>   
<div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type', ConstantDefine::getMenuType(),array('id'=>'menu_type','options' => array(ConstantDefine::MENU_TYPE_URL=>array('selected'=>true)))); ?>
        <?php echo $form->error($model,'type'); ?>
</div>
<div class="row" >
        <?php echo $form->labelEx($model,'value'); ?>
    
        <!-- Start for the form of URL  -->
        <div class="type_form" id="type_form_div_<?php echo ConstantDefine::MENU_TYPE_URL; ?>" style="display: none">
             <input type="text" name="type_form_<?php echo ConstantDefine::MENU_TYPE_URL; ?>" id="type_form_<?php echo ConstantDefine::MENU_TYPE_URL; ?>" value="" class="text_type_form simple_text_type_form"/>
        </div>
        
        <!-- Start for the form of Page Autocomplete -->
        <div class="type_form" id="type_form_div_<?php echo ConstantDefine::MENU_TYPE_PAGE; ?>" style="display: none">
        <?php $this->widget('CAutoComplete', array(
                            'name'=>'type_form_'.ConstantDefine::MENU_TYPE_PAGE,
                            'url'=>array('suggestPage'),
                            'value'=> ($model->isNewRecord) ? '' : MenuItem::ReBindValueForMenuType($model->type,$model->value),
                            'multiple'=>false,
                            'mustMatch'=>true,
                            'htmlOptions'=>array('size'=>50,'class'=>'text_type_form maxWidthInput','id'=>'type_form_'.ConstantDefine::MENU_TYPE_PAGE),
                            'methodChain'=>".result(function(event,item){ if(item!==undefined) \$(\"#menu_value\").val(item[1]);})",
                    )); ?>
        </div>
        
        
        <!-- Start for the form of Term Autocomplete -->
        <div class="type_form" id="type_form_div_<?php echo ConstantDefine::MENU_TYPE_TERM; ?>" style="display: none">
        <?php $this->widget('CAutoComplete', array(
                            'name'=>'type_form_'.ConstantDefine::MENU_TYPE_TERM,
                            'url'=>array('suggestTerm'),
                            'value'=> ($model->isNewRecord) ? '' : MenuItem::ReBindValueForMenuType($model->type,$model->value),
                            'multiple'=>false,
                            'mustMatch'=>true,
                            'htmlOptions'=>array('size'=>50,'class'=>'text_type_form maxWidthInput','type_form_'.ConstantDefine::MENU_TYPE_TERM),
                            'methodChain'=>".result(function(event,item){ if(item!==undefined)  \$(\"#menu_value\").val(item[1]);})",
                    )); ?>
        
        </div>        
                
       <!-- Start for the form of String  -->
       <div class="type_form" id="type_form_div_<?php echo ConstantDefine::MENU_TYPE_STRING; ?>" style="display: none">
           <input type="text" name="type_form_<?php echo ConstantDefine::MENU_TYPE_STRING; ?>" id="type_form_<?php echo ConstantDefine::MENU_TYPE_STRING; ?>" value="" class="text_type_form simple_text_type_form" />
       </div>
        
        
        <?php echo $form->hiddenField($model,'value', array('id'=>'menu_value')); ?>
        <?php echo $form->error($model,'value'); ?>
       <script type="text/javascript">
          
           var current_menu_type=$('#menu_type').val();
           $('.type_form').hide();
           $('#type_form_div_'+current_menu_type).show();
           
           $('#menu_type').change(function() {               
               $('.type_form').hide();
               $('#type_form_div_'+$(this).val()).show();
           });
           
           
           $('.simple_text_type_form').keyup(function() {                                             
               $('#menu_value').val($(this).val());
           });
           
            $('.simple_text_type_form').change(function() {                              
              
               $('#menu_value').val($(this).val());
           });
           
          
           
       </script>
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

</script>
<?php endif; ?>