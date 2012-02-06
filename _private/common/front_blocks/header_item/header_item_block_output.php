<div class="bleft" style="width:150px">
    <h1><a href="<?php echo FRONT_SITE_URL; ?>"><img src="<?php echo $this->layout_asset.'/images/logo.jpg'; ?>" alt=""/></a></h1>     
</div>
<div class="bleft" style="width:850px;">                
   <ul class="share-frame">
	<li class="share-text">Share with your friends:</li>
	<?php 
		$content_to_share=CHtml::encode("SALE ".$data->obj_sale_percent.'% - '.$data->obj_brand_name." ".$data->object_name.' '.$data->obj_sale_price.'$ - OnSaleGrab.com!');
		$url_to_share=CHtml::encode(FRONT_SITE_URL.'/item/'.$data->object_id.'/'.$data->object_slug);
	?>
    <li><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $url_to_share; ?>&layout=button_count&colorscheme=dark"
        scrolling="no" frameborder="0"
       style="border:none; width:80px; height:30px"></iframe></li>
  	<li style="padding-left:0; margin-left:0"><iframe allowtransparency="true" frameborder="0" scrolling="no"
        src="//platform.twitter.com/widgets/tweet_button.html"
       style="width:80px; height:20px;"></iframe></li>   
    <li><a title="Turn back" class="back" href="javascript: history.go(-1)">Back</a></li>
    <li style="padding-top:1px; float:right"><a class="remove-frame" href="<?php echo $data->obj_link;?>" title="Remove Frame"><img width="16px" src="<?php echo $this->layout_asset.'/images/dummy.gif'; ?>" alt="" /></a></li>   
	</ul>

</div>
<div class="clear"></div>
