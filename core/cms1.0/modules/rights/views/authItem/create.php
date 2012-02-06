<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
); ?>

<div class="createAuthItem">

	<?php Yii::app()->controller->pageTitle = Rights::t('core', 'Create :type', array(
		':type'=>Rights::getAuthItemTypeName($_GET['type']),
	)); ?>

	<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>

</div>