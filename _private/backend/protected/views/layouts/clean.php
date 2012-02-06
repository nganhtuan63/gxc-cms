<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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

<body style="padding:10px">
<div class="container" id="page">  
    <?php echo $content; ?>			
</div><!-- page -->
</body>
</html>