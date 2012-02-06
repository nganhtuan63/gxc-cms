<?php
$this->pageTitle=t('Fetch Colors');
$this->pageHint=t('Here you can fetch Colors for Items'); 
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array(
			'name'=>'Total Product',
			'type'=>'raw',
			'value'=>Color::GetTotalObject(),
		    ),
		array(
			'name'=>'Total Fetch Color',
			'type'=>'raw',
			'value'=>Color::GetTotalObject('1'),
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
<input type="button" value="Fetch Color" onClick="window.location.href='<?php echo bu();?>/obcolor/fetchcolor'" />
<input type="button" value="Reset Color" onClick="window.location.href='<?php echo bu();?>/obcolor/resetcolor'" />
</div>

