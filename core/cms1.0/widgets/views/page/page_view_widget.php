<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'block_id',
			'type'=>'raw',			
			'value'=>$model->page_id,
		    ),
                
		array(
			'name'=>'name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->name,array("update","id"=>$model->page_id)),
		    ),
                'layout',
                array(
                        'name'=>'lang',
			'type'=>'raw',			
			'value'=>Language::convertLanguage($model->lang),                   
                )
             
                
	),
)); ?>
