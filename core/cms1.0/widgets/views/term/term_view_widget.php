<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'term_id',
			'type'=>'raw',			
			'value'=>$model->term_id,
		    ),
                
		array(
			'name'=>'name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->name,array("update","id"=>$model->term_id)),
		    ),
             
              
                'description',		
		
	),
)); ?>
