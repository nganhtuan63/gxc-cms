<?php
$this->pageTitle='Crawl Bot';
$this->pageHint=t('Here you can Crawl Brand Page'); 
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array(
			'name'=>'Total Crawl Queues',
			'type'=>'raw',
			'value'=>CrawlQueue::GetTotalCrawlQueue(),
		    ),
		array(
			'name'=>'Total PENDING Crawl Queues',
			'type'=>'raw',
			'value'=>CrawlQueue::GetTotalCrawlQueue(OsgConstantDefine::CRAWL_STATUS_ON_WAIT),
		    ),
		array(
			'name'=>'Total FAILED Crawl Queues',
			'type'=>'raw',
			'value'=>CrawlQueue::GetTotalCrawlQueue(OsgConstantDefine::CRAWL_STATUS_FAILED),
		    ),
		array(
			'name'=>'Total SUCCESS Crawl Queues',
			'type'=>'raw',
			'value'=>CrawlQueue::GetTotalCrawlQueue(OsgConstantDefine::CRAWL_STATUS_SUCCESS),
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
<input type="button" value="Random Crawl" onClick="window.location.href='<?php echo bu();?>/obbot/docrawl'" />
</div>