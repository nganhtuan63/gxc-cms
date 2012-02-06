<?php 
$this->pageTitle=t('Manage Pages');
$this->pageHint=t('Here you can manage your Pages'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'Page')); 
?>