<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
        array('name'=>'comment_id',
			'type'=>'raw',			
			'value'=>$model->comment_id,
		    ),
        array(
			'name'=>'object_id',
			'type'=>'raw',
			'value'=>CHtml::link($model->object_id,array("beobject/view","id"=>$model->object_id)),
			),        
		array(
			'name'=>'topic',
			'type'=>'raw',		
			'value'=>$model->topic,
		    ),
		array(
			'name'=>'content',
			'type'=>'raw',
			'value'=>$model->content,
			),
        'author_name',
        array(
			'name'=>'status',
			'value'=>Comment::getStatus($model->status),
			),
        array(
			'name'=>'create_time',
			'value'=>date("Y-m-d H:i:s", $model->create_time)
			),
	),
)); ?>
