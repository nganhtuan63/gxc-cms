<?php
$this->pageTitle=t('Brand details');
$this->pageHint=t('View Brand details'); 
?>

<?php   $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'brand_name',
		array(
			'name'=>'Allow Crawl',
			'type'=>'image',
			'value'=>Brand::convertCrawlState($model),
		    ),
		array(
			'name'=>'Allow Parse',
			'type'=>'image',
			'value'=>Brand::convertParseState($model),
		    ),
		array(
			'name'=>'Total Brand Page',
			'type'=>'raw',
			'value'=>Brand::getTotalBrandPages($model)
		    ),
		array(
			'name'=>'Crawl Stats',
			'type'=>'raw',
			'value'=>Brand::getStatCrawl($model)
		    ),
		array(
			'name'=>'Parse Stats',
			'type'=>'raw',
			'value'=>Brand::getStatParse($model)
		    ),
		
		array(
			'name'=>'Last Crawled on',
			'type'=>'raw',
			'value'=>date("Y-m-d H:i:s",$model->brand_last_crawled)
		    ),
		array(
			'name'=>'Day(s) for ReCrawl',
			'type'=>'raw',
			'value'=>Brand::getFormRevisit($model)
		    ),
		array(
			'name'=>'Next Crawl on',
			'type'=>'raw',
			'value'=>Brand::getNextCrawl($model)
		    ),
		array(
			'name'=>'Image',
			'type'=>'raw',
			'value'=>Brand::getBrandImage($model)
		    ),
		array(
			'name'=>'Brand name for parse',
			'type'=>'raw',
			'value'=>Brand::getBrandNameParse($model)
		    ),
		
	),
)); ?>

<div id="rowFetch" style="margin-top:15px">
<h3>Fetch List</h3>
<?php
$count=1;
foreach($brand_fetchs as $bp) : ?>
<a href="<?php echo bu();?>/obfetch/newtest/id/<?php echo $bp->pf_id; ?>" target="_blank">Check Fetch Item <?php echo $count;?></a> &nbsp; &nbsp;
<?php
$count++;
endforeach ; ?>
</div>

<div id="rowCrawlParse" style="margin-top:15px">
<h3>Crawl &amp; Parse Control</h3>
<?php if($model->brand_allow_crawl==OsgConstantDefine::BRAND_ALLOW_CRAWL) :?>
<input type="button" value="Disable Crawl" onClick="window.location.href='<?php echo bu();?>/obbrand/crawlstate/id/<?php echo $model->brand_id; ?>/type/<?php echo OsgConstantDefine::BRAND_NOT_ALLOW_CRAWL; ?>'" />
<?php else : ?>
<input type="button" value="Allow Crawl" onClick="window.location.href='<?php echo bu();?>/obbrand/crawlstate/id/<?php echo $model->brand_id; ?>/type/<?php echo OsgConstantDefine::BRAND_ALLOW_CRAWL; ?>'" />
<?php endif; ?>

<?php if($model->brand_allow_parse==OsgConstantDefine::BRAND_ALLOW_PARSE) :?>
<input type="button" value="Disable Parse" onClick="window.location.href='<?php echo bu();?>/obbrand/parsestate/id/<?php echo $model->brand_id; ?>/type/<?php echo OsgConstantDefine::BRAND_NOT_ALLOW_PARSE; ?>'" />
<?php else : ?>
<input type="button" value="Allow Parse" onClick="window.location.href='<?php echo bu();?>/obbrand/parsestate/id/<?php echo $model->brand_id; ?>/type/<?php echo OsgConstantDefine::BRAND_ALLOW_PARSE; ?>'" />
<?php endif; ?>
</div>

<div id="rowCrawlQueue" style="margin-top:15px">
<h3>Queue</h3>

<input type="button" value="Empty Crawl Queue" onClick="if(confirm('Are you sure to EMPTY CRAWL QUEUE OF THIS BRAND ?')){ window.location.href='<?php echo bu();?>/obbrand/emptycrawl/id/<?php echo $model->brand_id; ?>' }" />

<input type="button" value="Empty Parse Queue" onClick="if(confirm('Are you sure to EMPTY PARSE QUEUE OF THIS BRAND ?')){ window.location.href='<?php echo bu();?>/obbrand/emptyparse/id/<?php echo $model->brand_id; ?>' }" />

<input type="button" value="Add Brand Pages to Crawl Queue" onClick="if(confirm('Are you sure to EMPTY EXISTING CRAWL AND PARSE QUEUE AND ADD NEW ?')){ window.location.href='<?php echo bu();?>/obbrand/addcrawlqueue/id/<?php echo $model->brand_id; ?>' }" />
</div>

<script type="text/javascript">
function changeRevisit(id){
	var next_value=$('#brand_revisit').val();
	<?php echo CHtml::ajax(array(
			// the controller/function to call
			'url'=>BeController::createUrl('obbrand/changerevisit'), 
			// Data to be passed to the ajax function
			// Note that the ' should be escaped with \
			// The field id should be prefixed with the model name eg Vehicle_field_name
			'data'=>array('brand_id'=>'js:id',
				      'next_value'=>'js:next_value',
                                      'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
	 
			// To pass multiple fields, just repeat eg:
			//              'chassis_number'=>'js:$(\'#Vehicle_chassis_number\').val()',
			),
			'type'=>'post',
			'dataType'=>'html',
			'success'=>"function(data)
			{
			    if (data=='0')
			    {
				alert('Error while Saving');
				return;
			    } else {
				alert('Updated!');
			    }
			} ",
	));?>
}

function changeBrandForParse(id){
	var next_value=$('#brand_for_parse_value').val();
	<?php echo CHtml::ajax(array(
			// the controller/function to call
			'url'=>BeController::createUrl('obbrand/changebrandparse'), 
			// Data to be passed to the ajax function
			// Note that the ' should be escaped with \
			// The field id should be prefixed with the model name eg Vehicle_field_name
			'data'=>array('brand_id'=>'js:id',
				      'next_value'=>'js:next_value',
                                       'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
	 
			// To pass multiple fields, just repeat eg:
			//              'chassis_number'=>'js:$(\'#Vehicle_chassis_number\').val()',
			),
			'type'=>'post',
			'dataType'=>'html',
			'success'=>"function(data)
			{
			    if (data=='0')
			    {
				alert('Error while Saving');
				return;
			    } else {
				alert('Updated!');
				$('#brand_for_parse_value').val(data);
			    }
			} ",
	));?>
}


function changeBrandImage(id){

	var next_value=$('#brand_image_value').val();
	<?php echo CHtml::ajax(array(
			// the controller/function to call
			'url'=>BeController::createUrl('obbrand/changeimage'), 
			// Data to be passed to the ajax function
			// Note that the ' should be escaped with \
			// The field id should be prefixed with the model name eg Vehicle_field_name
			'data'=>array('brand_id'=>'js:id',
				      'next_value'=>'js:next_value',
                                       'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
	 
			// To pass multiple fields, just repeat eg:
			//              'chassis_number'=>'js:$(\'#Vehicle_chassis_number\').val()',
			),
			'type'=>'post',
			'dataType'=>'html',
			'success'=>"function(data)
			{
			    if (data=='0')
			    {
				alert('Error while Saving');
				return;
			    } else {
				alert('Updated!');
				$('#brand_src_image').attr('src',data);
			    }
			} ",
	));?>
}


function changeNextCrawl(id,type){
	
	var next_value=1;
	if(type==1)
	var next_value=$('#brand_next_crawl_value').val();
	<?php echo CHtml::ajax(array(
			// the controller/function to call
			'url'=>BeController::createUrl('obbrand/changenextcrawl'), 
			// Data to be passed to the ajax function
			// Note that the ' should be escaped with \
			// The field id should be prefixed with the model name eg Vehicle_field_name
			'data'=>array('brand_id'=>'js:id',
				      'next_value'=>'js:next_value',
                                      'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
 
			// To pass multiple fields, just repeat eg:
			//              'chassis_number'=>'js:$(\'#Vehicle_chassis_number\').val()',
			),
			'type'=>'post',
			'dataType'=>'html',
			'success'=>"function(data)
			{
			    if (data=='0')
			    {
				alert('Error while Saving');
				return;
			    } else {
				alert('Updated!');
				$('#brand_next_crawl_value').val(data);
			    }
			} ",
	));?>
}


</script>

