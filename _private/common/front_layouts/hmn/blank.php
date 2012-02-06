<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="utf-8">
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
            $layout_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.front_layouts.hmn.assets'), false, -1, true);
        else
            $layout_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.front_layouts.hmn.assets'), false, -1, false);
    ?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $layout_asset; ?>/css/bootstrap.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $layout_asset; ?>/css/application.css" media="screen" />
     <link rel="stylesheet" type="text/css" href="<?php echo $layout_asset; ?>/css/wmd.css" media="screen" />
    <style type="text/css">
       html, body {
        background-color: #fff;
      }
      body {
        padding-top: 0px;
        
      }
       .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
                
                
      }

      /* Page header tweaks */
      .page-header {
       	margin-bottom:0px;
      }
      
      .content .span11{
      	border-right: 1px solid #eee;
      }
      .content .span5 {
        margin-left: 0;
        padding-left: 19px;
        
      }
      
     .pills a {
  		color:#444;
	  }
	.pills a:hover {		  
		  background-color: #CCC;
		}
		.pills .active a {
		 color: #EEE;
		background-color: #888;
		}
    </style>

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
		$cs->registerScriptFile( $layout_asset.'/js/bootstrap-dropdown.js');
		$cs->registerScriptFile( $layout_asset.'/js/util.js');
		
		                 	       
    ?>
    <title><?php if(isset($title)) 
                    { echo $title. " - ".Yii::app()->name; } 
                    else if (isset($_GET['id'])) {
                        $data = ObjectSale::model()->findByPk($_GET['id']);
                        if ($data)
                            echo $data->object_title.' - '.ConstantDefine::SITE_NAME_URL;
                        else    
                            echo $page->title.' - '.ConstantDefine::SITE_NAME_URL;
                    }
                    else    
                        echo $page->title.' - '.ConstantDefine::SITE_NAME_URL; ?></title>
  </head>

  <body>
	<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'4','layout_asset'=>$layout_asset,'data'=>null)); ?>

  </body>
</html>
