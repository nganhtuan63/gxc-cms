<?php
$this->pageTitle='Resize Image';
$this->pageHint=t('Here you can Resize Images'); 
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
            'name'=>'Total Crawed Images',
            'type'=>'raw',
            'value'=>ObjectSale::model()->count('obj_local_image<>""'),
            ),    
		array(
			'name'=>'Total Resized Images',
			'type'=>'raw',
			'value'=>ObjectSale::model()->count('obj_local_image<>"" and obj_resize=1'),
		    ),
		array(
			'name'=>'Total Images to Resize',
			'type'=>'raw',
			'value'=>ObjectSale::model()->count('obj_local_image<>"" and obj_resize=0'),
		    ),		
	))); 
?>
<br />
<br />
<?php    
    if (isset($list_success_object))  {
        echo "<h3 style='margin-bottom:0'>List of resized images : ".$list_success_object->totalItemCount." images</h3>";
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
                    'name'=>'Original (Local)',
                    'type'=>'raw',
                    'value'=>'CHtml::image(IMAGES_URL."/".OsgConstantDefine::IMAGE_ORIGINAL_FOLDER."/".$data->obj_local_image,"",array())',
                ),
                array(                         
                    'name'=>'Resized',
                    'type'=>'raw',
                    'value'=>'CHtml::image(IMAGES_URL."/".OsgConstantDefine::IMAGE_RESIZE_FOLDER."/".$data->obj_local_image,"",array())',                    
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
<input type="button" value="Random Resize" onClick="window.location.href='<?php echo bu();?>/obbot/doresizeimage'" />
<input type="button" value="Resize All" onClick="window.location.href='<?php echo bu();?>/obbot/doresizeimageall'" />
</div>