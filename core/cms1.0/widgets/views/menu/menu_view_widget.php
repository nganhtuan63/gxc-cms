<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
                array('name'=>'menu_id',
			'type'=>'raw',			
			'value'=>$model->menu_id,
		    ),
                
		array(
			'name'=>'menu_name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->menu_name,array("update","id"=>$model->menu_id)),
		    ),
             
                'menu_description',		
		array(
                        'name'=>'lang',
			'type'=>'raw',			
			'value'=>Language::convertLanguage($model->lang),                   
                )
	),
)); ?>
