<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>	    
	<?php 
        
        if(isset($this->backend_asset)){
            $backend_asset=$this->backend_asset;
        } else {
            if(YII_DEBUG)
                $backend_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.backend'), false, -1, true);
            else
                 $backend_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.backend'), false, -1, false);
        }
        $this->renderPartial('/layouts/header',array('backend_asset'=>$backend_asset)); 
        
        ?>
</head>
<body>
<div class="container" id="page" style="text-align:center">
	
            	<?php echo $content; ?>
	

</div><!-- page -->
 
</body>
</html>