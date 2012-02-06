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
        background-color: #eee;
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
	<div class="top_header">
		<div class="container">
			<div class="row">
				<div class="span8">
					<a  href="<?php echo FRONT_SITE_URL; ?>"><img class="logo" width="267px" height="48px" src="<?php echo $layout_asset;?>/images/dummy.gif" /></a>
					
				</div>
				<div class="span8">
					<ul class="nav secondary-nav" style="margin:10px 0px 0px 0; position:relative">
				  	<?php if(!user()->isGuest) : ?>
				  		<li>
				  		<a  href="<?php echo bu();?>/dashboard"><img class="head_avatar" src="<?php echo GxcHelpers::getUserAvatar('23',user()->getModel()->avatar,$layout_asset.'/images/avatar_23.png');?>" /><span class="head_username"><?php echo user()->getModel()->display_name; ?></span></a>
				  		</li>
				  		<li><span class="link_sep">|</span></li>
				  		 <li><a href="<?php echo bu();?>/user/logout"><?php echo t('Đăng xuất'); ?></a></li>
						  
				       	</li>     
				    <?php else : ?>
				    	<li><a href="<?php echo bu();?>/sign-in"">Đăng nhập</a></li>
				    	<li><span class="link_sep">|</span></li>  
				    	<li><a href="<?php echo bu();?>/sign-up"">Đăng ký</a></li>
				    <?php endif; ?>  
				
				  </ul>
  
				</div>
			</div>
			
			
		</div>
		
	</div>
    <div class="topbar">
      <div class="fill">
        <div class="container">
          	 <?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'0','layout_asset'=>$layout_asset,'data'=>null)); ?>
        </div>
      </div>
    </div>

    <div class="container"> 
	  <div class="content">
	  	<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'1','layout_asset'=>$layout_asset,'data'=>null)); ?>
	  
	  <div class="row">
	  	<div class="span16">
	  		<ul class="breadcrumb">
	  		<?php
	  			switch($page->slug) {
					case 'home':
						echo '<li><a href="'.FRONT_SITE_URL.'">Trang chủ</a> <span class="divider">/</span></li>';	
					break;
					default:
						echo '<li><a href="'.FRONT_SITE_URL.'">Trang chủ</a> <span class="divider">/</span></li>';
						echo '<li class="active">'.$page->title.'</li>';
					break;
	  			}
	  		?>
	  		</ul>			  			  

	  		<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'4','layout_asset'=>$layout_asset,'data'=>null)); ?>	
	  	</div>
	  </div>
	  <div class="row">
          <div class="span11" style="margin-left:0;width:640px">
          	<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'2','layout_asset'=>$layout_asset,'data'=>null)); ?>
         
          </div>
          <div class="span5">
          	               
          	<?php $this->widget('BlockRenderWidget',array('page'=>$page,'region'=>'3','layout_asset'=>$layout_asset,'data'=>null)); ?>
            
						
            
            
          </div>
        </div>
	  </div>          
		<ul class="footer_menu">
			<li class="first-child"><a href="#">Trang chủ</a></li>
			<li><a href="#">Giới thiệu</a></li>
			<li><a href="#">Hướng dẫn chia sẻ bài</a></li>
			<li><a href="#">Điều khoản sử dụng</a></li>
			<li><a href="#">Liên hệ</a></li>
		</ul>
		<div class="clear"></div>
      <footer>
        <p>&copy; HocMoiNgay.com 2012</p>
      </footer>

    </div> 

  </body>
</html>
