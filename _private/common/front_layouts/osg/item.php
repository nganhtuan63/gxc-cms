<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php if(isset($description)) { echo $description; } else echo $page->description; ?>" />
    <meta name="keywords" content="<?php if(isset($keywords)) { echo $keywords; } else echo $page->keywords ?>" />
    <meta name="robots" content="<?php echo ($page->allow_index) ? 'index' : 'noindex' ;?>, <?php echo ($page->allow_follow) ? 'follow' : 'nofollow' ;?>" />
    <meta name="author" content="GxcSolutions" />
    <meta name="copyright" content="GxcSolutions" />
    <?php
        if(YII_DEBUG)
            $layout_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.front_layouts.osg.assets'), false, -1, true);
        else
            $layout_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.front_layouts.osg.assets'), false, -1, false);
    ?>
        
    <link rel="shortcut icon" href="<?php echo $layout_asset; ?>/images/favicon.ico" type="image/x-icon" />    
    <link rel="stylesheet" type="text/css" href="<?php echo $layout_asset; ?>/css/jquery-ui.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $layout_asset; ?>/css/screen.css" media="screen" />
  
     
        
    <title><?php 
     $data = ObjectSale::model()->findByPk($_GET['id']);
    if (!$data)
        throw new CHttpException('404','Page not found');   
	else {
		$content_to_share=CHtml::encode("SALE ".$data->obj_sale_percent.'% - '.$data->obj_brand_name." ".$data->object_name.' '.$data->obj_sale_price.'$ - OnSaleGrab.com!');
		echo $content_to_share;	
	}
			
    ?>
   </title>
        
    <?php    
        $cs=Yii::app()->clientScript;
                
        $cs->scriptMap=array(
            'jquery.js'=>"http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js",            
            'jquery.min.js'=>"http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js",
            'jquery-ui.js'=>"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js",
            'jquery-ui.min.js'=>"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js",
            'jquery-ui.css'=>false
            
        );        
        $cs->registerCoreScript('jquery');        
        $cs->registerCoreScript('jquery.ui');   
        $cs->registerScriptFile( $layout_asset.'/js/jquery.infinitescroll.js');        
        $cs->registerScriptFile( $layout_asset.'/js/jquery.hoverIntent.minified.js'); 
        //$cs->registerScriptFile( $layout_asset.'/js/jquery.ui.touch-punch.min.js'); 
        //$cs->registerScriptFile( $layout_asset.'/js/jquery.mousewheel.js'); 
        //$cs->registerScriptFile( $layout_asset.'/js/mwheelIntent.js'); 
        //$cs->registerScriptFile( $layout_asset.'/js/jquery.jscrollpane.min.js');         
        $cs->registerScriptFile( $layout_asset.'/js/util.js?v=3');        
    ?>
    <script charset="utf-8" src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
    
</head>
<body onLoad="resizeIframe();">   
	<div id="container" style="height:100%">
    	<div id="header">
            <div class="innerHeader">
            	<div class="deepinnerHeader" style="width:1000px;"> 
                   <?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'0','layout_asset'=>$layout_asset,'data'=>$data)); ?>
                </div>    
            </div>                        	                
        </div>
        <div id="main"  style="width:100%; height:100%;">
                <?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'4','layout_asset'=>$layout_asset,'data'=>$data)); ?>                           	
        </div>
    </div>
    <script type="text/javascript">
    	function resizeIframe(){    		
    		$('#preview-frame').css('height',($(window).height()-51));
    	}
    	$(function(){
		    $(window).resize(function(){
		        resizeIframe();		        		        
		    });
		});
    </script>
</body>
</html>