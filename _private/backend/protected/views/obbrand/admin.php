<?php
$this->pageTitle=t('Manage Brands');
$this->pageHint=t('Here you can manage your Brands'); 
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'brand_id',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridmaxwidth'),
			'value'=>'$data->brand_id',
		    ),
		array(
			'name'=>'brand_name',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'gridLeft'),
			'value'=>'CHtml::link($data->brand_name,array("obbrand/view","id"=>$data->brand_id))',
		    ),        
        /*
		'updated',
		'creator',
		*/
        array
        (
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array
            (
            'update' => array
            (
                'label'=>'Edit',
                'imageUrl'=>false,
                'url'=>'Yii::app()->createUrl("obbrand/update", array("id"=>$data->brand_id))',
            ),
            ),
        ),
       
	),
)); ?>

