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
     
        
    <title><?php if(isset($title)) 
                    { echo $title. " - ".Yii::app()->name; } 
                    else if (isset($_GET['id'])) {
                        $data = ObjectSale::model()->findByPk($_GET['id']);
                        if ($data)
                            echo $data->object_title;
                        else    
                            echo $page->title;
                    }
                    else    
                        echo $page->title; ?></title>
        
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
</head>
<body>   
	<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'4','layout_asset'=>$layout_asset,'data'=>null)); ?>    
</body>
</html>