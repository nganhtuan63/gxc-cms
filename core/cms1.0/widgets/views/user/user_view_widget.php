<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'username',
		'email',
		
		'display_name',
		 array(
		'name'=>'status',
			'type'=>'image',
			'value'=>User::convertUserState($model),
		    ),
		 array(
		'name'=>'created_time',
			'type'=>'raw',
			'value'=>date("Y-m-d H:i:s", $model->created_time),
		    ),
		 array(
		'name'=>'updated_time',
			'type'=>'raw',
			'value'=>date("Y-m-d H:i:s", $model->updated_time),
		    ),
		 array(
		'name'=>'recent_login',
			'type'=>'raw',
			'value'=>date("Y-m-d H:i:s", $model->recent_login),
		    ),
	),
)); ?>
