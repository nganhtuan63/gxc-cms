<?php 
$this->pageTitle=t('Manage Content List');
$this->pageHint=t('Here you can manage your Content List'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'ContentList')); 
?>