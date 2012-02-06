<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'taxonomy_id',
			'type'=>'raw',			
			'value'=>$model->taxonomy_id,
		    ),
                
		array(
			'name'=>'name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->name,array("update","id"=>$model->taxonomy_id)),
		    ),
             
                array(
			'name'=>'type',
			'type'=>'raw',			
			'value'=>Object::convertObjectType($model->type),
		    ),
                'description',		
		array(
                        'name'=>'lang',
			'type'=>'raw',			
			'value'=>Language::convertLanguage($model->lang),                   
                )
	),
)); ?>
