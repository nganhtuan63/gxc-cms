<?php 
$this->pageTitle=t('Manage Users');
$this->pageHint=t('Here you can view all members information of your site'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'User')); 
?>