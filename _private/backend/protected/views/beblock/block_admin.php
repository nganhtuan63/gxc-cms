<?php 
$this->pageTitle=t('Manage Blocks');
$this->pageHint=t('Here you can manage your Blocks'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'Block')); 
?>