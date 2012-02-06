<?php 
$this->pageTitle=t('Update Page');
$this->pageHint=t('Here you can update information for current Page'); 
?>
<?php 
$add_existed_block_url=Yii::app()->controller->createUrl('beblock/suggestblock',array('embed'=>'iframe'));    
$add_new_block_url=Yii::app()->controller->createUrl('beblock/create',array());    
$update_block_url=Yii::app()->controller->createUrl('beblock/update',array('embed'=>'iframe')); 
$this->widget('cmswidgets.page.PageUpdateWidget',array(
    'add_existed_block_url'=>$add_existed_block_url,
    'add_new_block_url'=>$add_new_block_url,
    'update_block_url'=>$update_block_url,    
)); 
?>