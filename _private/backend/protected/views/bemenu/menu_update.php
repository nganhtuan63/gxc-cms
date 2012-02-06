<?php 
$this->pageTitle=t('Update Menu');
$this->pageHint=t('Here you can update information for current Menu'); 
?>
<?php 
$form_create_url=Yii::app()->controller->createUrl('bemenuitem/create',array('embed'=>'iframe','menu'=>$id));    
$form_update_url=Yii::app()->controller->createUrl('bemenuitem/update',array('embed'=>'iframe','menu'=>$id));    
$form_change_order_url=Yii::app()->controller->createUrl('bemenuitem/changeorder',array());    
$form_delete_url=Yii::app()->controller->createUrl('bemenuitem/delete',array());  
$this->widget('cmswidgets.page.MenuUpdateWidget',array(
    'form_create_term_url'=>$form_create_url,
    'form_update_term_url'=>$form_update_url,
    'form_delete_term_url'=>$form_delete_url,
    'form_change_order_term_url'=>$form_change_order_url,
        )); 
?>