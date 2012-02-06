<?php
$this->pageTitle=t('Create a new Color');
$this->pageHint=t('Create new Color for the site'); 
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
