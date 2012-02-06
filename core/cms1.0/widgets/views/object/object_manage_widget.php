<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'object-grid',
	'dataProvider'=>$result,
	'filter'=>$model,
        'summaryText'=>t('Displaying').' {start} - {end} '.t('in'). ' {count} '.t('results'),
	'pager' => array(
		'header'=>t('Go to page:'),
		'nextPageLabel' => t('Next'),
		'prevPageLabel' => t('previous'),
		'firstPageLabel' => t('First'),
		'lastPageLabel' => t('Last'),
                'pageSize'=> Yii::app()->settings->get('system', 'page_size')
	),
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
			'value'=>'CHtml::link($data->object_name,array("'.app()->controller->id.'/view","id"=>$data->object_id))',
		    ),
                array(
			'name'=>'object_type',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft gridmaxwidth'),
			'value'=>'Object::convertObjectType($data->object_type)',
		    ),            
		array(
			'name'=>'object_status',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft gridmaxwidth'),
			'value'=>'Object::convertObjectStatus($data->object_status)',
		    ),
                array(
                        'name'=>'lang',
			'type'=>'raw',			
			'value'=>'Language::convertLanguage($data->lang)',                   
                ),
                array
		(
		    'class'=>'CButtonColumn',
		    'template'=>'{translate}',
		    'visible'=>Yii::app()->settings->get('system','language_number') > 1,
		    'buttons'=>array
		    (
			'translate' => array
			(
			   'label'=>t('Translate'),
			    'imageUrl'=>false,
			    'url'=>'Yii::app()->createUrl("'.app()->controller->id.'/create", array("guid"=>$data->guid,"type"=>$data->object_type))',
			),
		    ),
		),            		
		array
		(
		    'class'=>'CButtonColumn',
		    'template'=>'{update}',
		    'buttons'=>array
		    (
			'update' => array
			(
			    'label'=>t('Edit'),
			    'imageUrl'=>false,
			    'url'=>'Yii::app()->createUrl("'.app()->controller->id.'/update", array("id"=>$data->object_id))',
			),
		    ),
		),
		array
		(
		    'class'=>'CButtonColumn',
		    'template'=>'{delete}',
		    'buttons'=>array
		    (
			'delete' => array
			(
                            'label'=>t('Delete'),
			    'imageUrl'=>false,
			),

		    ),
		),
	),
)); ?>
