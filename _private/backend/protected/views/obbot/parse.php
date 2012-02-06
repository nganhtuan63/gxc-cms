<?php
$this->pageTitle='Parse Bot';
$this->pageHint=t('Here you can Parse Brand Page'); 
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array(
			'name'=>'Total Parse Queues',
			'type'=>'raw',
			'value'=>ParseQueue::GetTotalParseQueue(),
		    ),
		array(
			'name'=>'Total PENDING Parse Queues',
			'type'=>'raw',
			'value'=>ParseQueue::GetTotalParseQueue(OsgConstantDefine::PARSE_ON_WAIT),
		    ),
		array(
			'name'=>'Total FOUND Parse Queues',
			'type'=>'raw',
			'value'=>ParseQueue::GetTotalParseQueue(OsgConstantDefine::PARSE_FOUND),
		    ),
		array(
			'name'=>'Total NOT FOUND Parse Queues',
			'type'=>'raw',
			'value'=>ParseQueue::GetTotalParseQueue(OsgConstantDefine::PARSE_NOT_FOUND),
		    ),
		
	),
)); ?>

<div id="rowCrawlParse" style="margin-top:15px">
 <?php if(Yii::app()->user->hasFlash('success')):?>
		      <div class="user-flash message-success rounded">
			  <?php echo Yii::app()->user->getFlash('success'); ?>
		      </div>
		      <script type="text/javascript" >
			      $(".user-flash").delay(2100).fadeOut(1300);
		      </script>
		      <?php endif; ?>    
<h3>Action</h3>
<input type="button" value="Random Parse" onClick="window.location.href='<?php echo bu();?>/obbot/doparse'" />
</div>