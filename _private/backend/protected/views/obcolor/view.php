<?php
$this->pageTitle=t('Color details');
$this->pageHint=t('View Color details'); 
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'colorid',
		'colorname',
		'H',
		'S',
		'L',
	),
)); ?>

<?php

$dataProvider = new CActiveDataProvider('ObjectSale', array(
  'criteria'=>array(
    'order'=>'object_id',
	'condition'=>'obj_color_id = :cid',
	'params'=>array(
		':cid'=>$model->colorid,
		),
  ),	
));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'object_id',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'object_id',
		array(
			'type'=>'raw',
			'value'=>'CHtml::image($data->obj_image)',
		),
		'obj_color_id',

	),
)); ?>
