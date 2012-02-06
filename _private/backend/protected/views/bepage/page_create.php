<?php 
$this->pageTitle=t('Add new Page');
$this->pageHint=t('Here you can add new Page for your Site'); 

?>

<?php 
$add_existed_block_url=Yii::app()->controller->createUrl('beblock/suggestblock',array('embed'=>'iframe'));    
$add_new_block_url=Yii::app()->controller->createUrl('beblock/create',array());    
$update_block_url=Yii::app()->controller->createUrl('beblock/update',array('embed'=>'iframe'));  
$this->widget('cmswidgets.page.PageCreateWidget',array(
    'add_existed_block_url'=>$add_existed_block_url,
    'add_new_block_url'=>$add_new_block_url,
    'update_block_url'=>$update_block_url,
    
)); 
?>