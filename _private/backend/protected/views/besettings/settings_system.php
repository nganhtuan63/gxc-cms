<?php 
$this->pageTitle=t('Manage System Settings');
$this->pageHint=t('Here you can manage all Site System Settings'); 
?>
<?php $this->widget('cmswidgets.settings.SettingsWidget',array('type'=>'system')); 
?>