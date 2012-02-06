<?php 
$this->pageTitle=t('Update Content list');
$this->pageHint=t('Here you can update information for current Content list'); 
?>
<?php $this->widget('cmswidgets.page.ContentListUpdateWidget',array('object_update_url'=>'beobject/update')); ?>