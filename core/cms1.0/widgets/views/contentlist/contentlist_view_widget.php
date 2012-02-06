<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'content_list_id',
			'type'=>'raw',			
			'value'=>$model->content_list_id,
		    ),
                
		array(
			'name'=>'name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->name,array("update","id"=>$model->content_list_id)),
		    ),
             
              
	),
)); ?>
