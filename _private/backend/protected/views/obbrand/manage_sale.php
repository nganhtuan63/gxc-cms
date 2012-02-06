<?php
$this->pageTitle=t('Manage Object Sale');
$this->pageHint=t('Here you can manage all Object Sale'); 
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sale-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'object_id',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridmaxwidth'),
			'value'=>'$data->object_id',
		    ),
		array(
			'name'=>'object_name',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft'),
			'value'=>'CHtml::link($data->object_name,array("beobject/view","id"=>$data->object_id))',
		    ), 
                array(
			'name'=>'obj_link',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft'),
			'value'=>'CHtml::link($data->obj_link)',
		    ),
       
               'obj_sale_price',
               array(
			'name'=>'obj_image',
			'type'=>'image',			
			'value'=>'$data->obj_image',
		    ),
               
       
	),
)); ?>

