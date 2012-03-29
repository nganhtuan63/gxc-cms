<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'newsletter-grid',
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
		array('name'=>'newsletter_id',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridmaxwidth'),
			'value'=>'$data->newsletter_id',
		    ),
			array(
			'name'=>'topic',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft'),
			'value'=>'CHtml::link($data->topic,array("'.app()->controller->id.'/view","id"=>$data->newsletter_id))',
		    ),       
		array(
			'name'=>'status',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft gridmaxwidth'),
			'value'=>'Newsletter::getStatus($data->status)',
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
