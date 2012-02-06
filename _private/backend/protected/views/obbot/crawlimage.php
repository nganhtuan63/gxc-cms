<?php
$this->pageTitle='Crawl Image';
$this->pageHint=t('Here you can Crawl Images to store'); 
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array(
			'name'=>'Total Images',
			'type'=>'raw',
			'value'=>ObjectSale::model()->count('obj_image<>""'),
		    ),
		array(
			'name'=>'Total Crawled Images',
			'type'=>'raw',
			'value'=>ObjectSale::model()->count('obj_local_image<>""'),
		    ),
		array(
			'name'=>'Total Images to Crawl',
			'type'=>'raw',
			'value'=>ObjectSale::model()->count('obj_local_image=""'),
		    ),		
	))); 
    
    if (isset($list_success_object))  {
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'object_id',         
            'dataProvider'=>$list_success_object,
            'columns'=>array(
                array(
                    'name'=>'ID',
                    'type'=>'raw',
                    'value'=>'$data->object_id',
                ),
                array(
                    'name'=>'Name',
                    'type'=>'raw',
                    'value'=>'$data->object_name',
                ),
                array(
                    'name'=>'Link',
                    'type'=>'raw',
                    'value'=>'$data->obj_image',
                ),
                array(
                    'type'=>'raw',
                    'value'=>'CHtml::image($data->obj_image,"",array("style"=>"width:127px;height:170px"))',
                ),
                array(
                    'type'=>'raw',
                    'value'=>'CHtml::image(IMAGES_URL."/".OsgConstantDefine::IMAGE_ORIGINAL_FOLDER."/".$data->obj_local_image,"",array("style"=>"width:127px;height:170px"))',
                ),
            )));
    }
    if (isset($list_failed_object))  {
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'object_id',         
            'dataProvider'=>$list_failed_object,
            'columns'=>array(
                array(
                    'name'=>'ID',
                    'type'=>'raw',
                    'value'=>'$data->object_id',
                ),
                array(
                    'name'=>'Name',
                    'type'=>'raw',
                    'value'=>'$data->object_name',
                ),
                array(
                    'name'=>'Link',
                    'type'=>'raw',
                    'value'=>'$data->obj_image',
                ),
                array(
                    'type'=>'raw',
                    'value'=>'CHtml::image($data->obj_image,"",array("style"=>"width:127px;height:170px"))',
                ),
            )));
    }
 ?>

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
<input type="button" value="Random Crawl" onClick="window.location.href='<?php echo bu();?>/obbot/docrawlimage'" />
<input type="button" value="Crawl All" onClick="window.location.href='<?php echo bu();?>/obbot/docrawlimageall'" />
</div>