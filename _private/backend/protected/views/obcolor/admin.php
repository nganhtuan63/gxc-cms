<?php
$this->pageTitle=t('Manage Colors');
$this->pageHint=t('Here you can manage your Colors'); 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'color-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'colorid',
		'colorname',
		'H',
		'S',
		'L',
		array(
			'type'=>'raw',
			'value'=>'CHtml::link("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
				array("obcolor/view","id"=>$data->colorid),
				array("style"=>"background:HSL($data->H,$data->S%,$data->L%);text-decoration:none")
				)',
		),
		array
		(
		    'class'=>'CButtonColumn',
		    'template'=>'{update}',
		    'buttons'=>array
		    (
			'update' => array
			(
			    'label'=>t('Edit'),
			    'imageUrl'=>false,
			    'url'=>'Yii::app()->createUrl("'.app()->controller->id.'/update", array("id"=>$data->colorid))',
			),
		    ),
		),
               
	),
)); ?>
