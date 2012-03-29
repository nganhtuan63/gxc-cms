<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
        array('name'=>'newsletter_id',
			'type'=>'raw',			
			'value'=>$model->newsletter_id,
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
        array(
			'name'=>'status',
			'value'=>Newsletter::getStatus($model->status),
			),
        array(
			'name'=>'created_time',
			'value'=>date("Y-m-d H:i:s", $model->created_time)
			),
	),
)); ?>
