<?php
$this->pageTitle=t('Update Color');
$this->pageHint=t('Here you can update information for current Color');  
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>