<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            
        array('name'=>'resource_id',
			'type'=>'raw',			
			'value'=>$model->resource_id,
		    ),
                
		array(
			'name'=>'resource_name',
			'type'=>'raw',		
			'value'=>CHtml::link($model->resource_name,array("update","id"=>$model->resource_id)),
		    ),
             
       array(
			'name'=>'resource_path',
			'type'=>'raw',
			'htmlOptions'=>array(),
			'value'=>GxcHelpers::renderTextBoxResourcePath($model),
		    ),
		array(
			'name'=>'Preview',
			'type'=>'raw',
			'htmlOptions'=>array(),
			'value'=>GxcHelpers::renderLinkPreviewResource($model),
		    ),
        array(
			'name'=>'resource_type',
			'type'=>'raw',
			'htmlOptions'=>array(),
			'value'=>$model->resource_type,
		    ),
		array(
			'name'=>'where',
			'type'=>'raw',
			'htmlOptions'=>array(),
			'value'=>$model->where,
		    ),
	),
)); ?>

<script type="text/javascript">
function selectAllText(textbox) {
    textbox.focus();
    textbox.select();
}
$('.pathResource').click(function() { selectAllText(jQuery(this)) });
</script>