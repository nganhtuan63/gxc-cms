<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'block_id',
			'type'=>'raw',			
			'value'=>$model->block_id,
		    ),
                
		array(
			'name'=>'menu_name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->name,array("update","id"=>$model->block_id)),
		    ),
             
                
	),
)); ?>
