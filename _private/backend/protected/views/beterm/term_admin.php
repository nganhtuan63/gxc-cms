<?php 
$this->pageTitle=t('Manage Terms');
$this->pageHint=t('Here you can manage your Terms. <br /> <b>Note: </b>When you delete a Term, all contents belong to that Term will be moved to Uncategory Term'); 
?>
<?php $this->widget('cmswidgets.ModelManageWidget',array('model_name'=>'Term')); 
?>