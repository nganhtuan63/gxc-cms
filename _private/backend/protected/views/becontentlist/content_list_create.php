<?php 
$this->pageTitle=t('Add new Content list');
$this->pageHint=t('Here you can add new Content list'); 
?>
<?php $this->widget('cmswidgets.page.ContentListCreateWidget',array('object_update_url'=>'beobject/update')); 
?>