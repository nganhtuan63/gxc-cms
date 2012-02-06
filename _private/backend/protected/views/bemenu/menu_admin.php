<?php 
$this->pageTitle=t('Manage Menu');
$this->pageHint=t('Here you can manage your Menu'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'Menu')); 
?>