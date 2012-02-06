<?php
$this->pageTitle=t('Create a new Brand');
$this->pageHint=t('Create new Brand for the site'); 
?>
<?php echo $this->renderPartial('_form_brand', array('model'=>$model,'arr_fetch'=>$arr_fetch)); ?>