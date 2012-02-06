<?php 
$this->pageTitle=t('Manage Taxonomy');
$this->pageHint=t('Here you can manage your Taxonomy'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'Taxonomy')); 
?>