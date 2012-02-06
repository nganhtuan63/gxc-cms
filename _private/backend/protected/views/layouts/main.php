<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
	<?php 
        
        if(isset($this->backend_asset)){
            $backend_asset=$this->backend_asset;
        } else {
            $backend_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('cms.assets.backend'), false, -1, true);
        }
        $this->renderPartial('application.views.layouts.header',array('backend_asset'=>$backend_asset)); 
        
        ?>
</head>
<body>

<div class="container" id="page">
    <div id="language-bar" style="text-align: right; padding:5px 10px 5px 0px">
    	<?php	//shortcut
		$translate=Yii::app()->translate;				
		if($translate->hasMessages()){		
		  echo $translate->translateLink('Translate this Page')."|";				  
		}		
		echo $translate->editLink('Manage translations')."|";		
		echo $translate->missingLink('Missing translations');
		
		
		?>
    </div>
	<div id="nav">
		<div class="wrap">

				<ul class="left">
					<li><a href="<?php echo FRONT_SITE_URL; ?>" id="visit_site" target="_blank">Visit Website</a></li>					
				</ul>

				<ul class="right">
                                        <li>
                                            <?php	                                            
                                            $translate=Yii::app()->translate;
                                            echo $translate->dropdown();                                                                                       
                                             ?>
                                        &nbsp;</li>
					<li><?php echo t('Welcome'); ?>, <strong><?php echo user()->getModel()->display_name; ?></strong>&nbsp;|&nbsp;</li>
					<li><a href="<?php echo Yii::app()->request->baseUrl?>/beuser/updatesettings"><?php echo t('Settings'); ?></a>&nbsp;|&nbsp;</li>
					<li><a href="<?php echo Yii::app()->request->baseUrl?>/beuser/changepass"><?php echo t('Change Password'); ?></a>&nbsp;|&nbsp;</li>
					<li><a href="<?php echo Yii::app()->request->baseUrl?>/besite/logout"><?php echo t('Sign out'); ?></a></li>
				</ul>
				
		</div>
			
	</div>
	<div id="header">
		
		<form id="search-box" method="get" action="#" target="_blank">
			<input class="topSearchBox" id="topSearchBox" autocomplete="off" type="text" maxlength="2048" name="q" label="Search" placeholder="" aria-haspopup="true" />
			<input type="submit" value="Go" id="searchbutton" class="bebutton" />
		</form>
	</div>
	<div id="site-content">
		<div id="left-sidebar">
                    
                    <?php
			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					array('label'=>'<span id="menu_dashboard" class="micon"></span>'.t('Dashboard'), 'url'=>array('/besite/index') ,'linkOptions'=>array('class'=>'menu_0'),
                                                'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),
                                        array('label'=>'<span id="menu_brand" class="micon"></span>'.t('Brand'),  'url'=>'javascript:void(0);','linkOptions'=>array('class'=>'menu_8' ), 'itemOptions'=>array('id'=>'menu_8'), 
					       'items'=>array(
						array('label'=>t('Create Brand'), 'url'=>array('/obbrand/create')),						
						array('label'=>t('Manage Brands'), 'url'=>array('/obbrand/admin'),
						      'visible'=>user()->isAdmin ? true : false,
						      'active'=> ((Yii::app()->controller->id=='obbrand') && (in_array(Yii::app()->controller->action->id,array('update','view','admin')))) ? true : false),
                                                array('label'=>t('Manage Object Sales'), 'url'=>array('/obbrand/managesale')),
					    )),
                                        array('label'=>'<span id="menu_bot" class="micon"></span>'.t('Bot'),  'url'=>'javascript:void(0);','linkOptions'=>array('class'=>'menu_9' ), 'itemOptions'=>array('id'=>'menu_9'), 
					       'items'=>array(
						array('label'=>t('Crawl Bots'), 'url'=>array('/obbot/crawl')),						
                        array('label'=>t('Crawl Image'), 'url'=>array('/obbot/crawlimage')),                        
                        array('label'=>t('Resize Image'), 'url'=>array('/obbot/resizeimage')),                        
                                                array('label'=>t('Parse Bots'), 'url'=>array('/obbot/parse')),						
						
					    )),
                                        array('label'=>'<span id="menu_fetch" class="micon"></span>'.t('Fetch'),  'url'=>'javascript:void(0);','linkOptions'=>array('class'=>'menu_10' ), 'itemOptions'=>array('id'=>'menu_10'), 
					       'items'=>array(
						array('label'=>t('Test Product Fetch'), 'url'=>array('/obfetch/test')),						                                             
                                               
					    )),
                                        array('label'=>'<span id="menu_color" class="micon"></span>'.t('Color'),  'url'=>'javascript:void(0);','linkOptions'=>array('class'=>'menu_11' ), 'itemOptions'=>array('id'=>'menu_11'), 
					       'items'=>array(
                                                array('label'=>t('Fetch Color'), 'url'=>array('/obcolor/fetch')),						
						array('label'=>t('Create Color'), 'url'=>array('/obcolor/create')),						
                        array('label'=>t('Manage Object Colors'), 'url'=>array('/obcolor/index')),
						array('label'=>t('Manage Colors'), 'url'=>array('/obcolor/admin'),                               
						      'visible'=>user()->isAdmin ? true : false,
						      'active'=> ((Yii::app()->controller->id=='obcolor') && (in_array(Yii::app()->controller->action->id,array('update','view','admin')))) ? true : false)
					    )),
					array('label'=>'<span id="menu_content" class="micon"></span>'.t('Content'),  'url'=>'javascript:void(0);','linkOptions'=>array('class'=>'menu_1' ), 'itemOptions'=>array('id'=>'menu_1'), 
					       'items'=>array(
						array('label'=>t('Create Content'), 'url'=>array('/beobject/create')),
						array('label'=>t('Draft Content'), 'url'=>array('/beobject/draft')),
						array('label'=>t('Pending Content'), 'url'=>array('/beobject/pending')),
						array('label'=>t('Published Content'), 'url'=>array('/beobject/published')),
						array('label'=>t('Manage Content'), 'url'=>array('/beobject/admin'),
						      'visible'=>user()->isAdmin ? true : false,
						      'active'=> ((Yii::app()->controller->id=='beobject') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index')))) ? true : false)
					    )),
					array('label'=>'<span id="menu_taxonomy" class="micon"></span>'.t('Category'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_2','class'=>'menu_2'),  'itemOptions'=>array('id'=>'menu_2'),
					       'items'=>array(
						array('label'=>t('Create Term'), 'url'=>array('/beterm/create')),
						
						array('label'=>t('Manage Terms'), 'url'=>array('/beterm/admin'),
							'active'=> ((Yii::app()->controller->id=='beterm') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)                                                                                           
						      ),
						array('label'=>t('Create Taxonomy'), 'url'=>array('/betaxonomy/create')),
						array('label'=>t('Mangage Taxonomy'), 'url'=>array('/betaxonomy/admin'),
						    'active'=> ((Yii::app()->controller->id=='betaxonomy') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index')))) ? true : false)                                                                                     
					    
					    ),
					    'visible'=>user()->isAdmin ? true : false,   
					    ),
					array('label'=>'<span id="menu_page" class="micon"></span>'.t('Pages'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_3','class'=>'menu_3'), 'itemOptions'=>array('id'=>'menu_3'),
					       'items'=>array(
						array('label'=>t('Create Menu'), 'url'=>array('/bemenu/create'),'visible'=>user()->isAdmin ? true : false,),
						array('label'=>t('Manage Menus'), 'url'=>array('/bemenu/admin'),
								'active'=> ((Yii::app()->controller->id=='bemenu') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)),
						array('label'=>t('Create Queue'), 'url'=>array('/becontentlist/create'),'visible'=>user()->isAdmin ? true : false,),
						array('label'=>t('Manage Queues'), 'url'=>array('/becontentlist/admin'),
						    'active'=> ((Yii::app()->controller->id=='becontentlist') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)),
							
						array('label'=>t('Create Block'), 'url'=>array('/beblock/create'),'visible'=>user()->isAdmin ? true : false,),
						array('label'=>t('Manage Blocks'), 'url'=>array('/beblock/admin'),
						    'active'=> ((Yii::app()->controller->id=='beblock') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)),
							
			     
				
						array('label'=>t('Create Page'), 'url'=>array('/bepage/create'),'visible'=>user()->isAdmin ? true : false,),
						array('label'=>t('Manage Pages'), 'url'=>array('/bepage/admin'),
						    'active'=> ((Yii::app()->controller->id=='bepage') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index')))) ? true : false)
						)),
					array('label'=>'<span id="menu_resource" class="micon"></span>'.t('Resource'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_4','class'=>'menu_4'), 'itemOptions'=>array('id'=>'menu_4'), 
					       'items'=>array(
						array('label'=>t('Create Resource'), 'url'=>array('/resource/create')),
						array('label'=>t('Manage Resource'), 'url'=>array('/resource/admin'),
						     'active'=> ((Yii::app()->controller->id=='resource') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index')))) ? true : false)
						
					    )),
						array('label'=>'<span id="menu_manage" class="micon"></span>'.t('Manage'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_5','class'=>'menu_5'), 'itemOptions'=>array('id'=>'menu_5'), 
					       'items'=>array(
						array('label'=>t('Comments'), 'url'=>array('/comments/admin'),'active'=>Yii::app()->controller->id=='comments' ? true : false),
						//array('label'=>'Like/Rating', 'url'=>array('/like/admin')),
						//array('label'=>'Survey', 'url'=>array('/survey/admin')),
						     
						
					    )),
					array('label'=>'<span id="menu_user" class="micon"></span>'.t('User'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_6','class'=>'menu_6'), 'itemOptions'=>array('id'=>'menu_6'), 
					       'items'=>array(
						array('label'=>t('Create User'), 'url'=>array('/beuser/create')),
						array('label'=>t('Manage Users'), 'url'=>array('/beuser/admin'),
						      'active'=> ((Yii::app()->controller->id=='beuser') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index')))) ? true : false
						      ),
						array('label'=>t('Permission'), 'url'=>array('/rights/assignment'),'active'=>in_array(Yii::app()->controller->id,array('assignment','authItem')) ?true:false),
					    ),
                                                'visible'=>user()->isAdmin ? true : false,   
					    ),
                                        array('label'=>'<span id="menu_setting" class="micon"></span>'.t('Settings'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_7','class'=>'menu_7'), 'itemOptions'=>array('id'=>'menu_7'), 
                                                           'items'=>array(
                                                               array('label'=>t('General'), 'url'=>array('/besettings/general')),
                                                               array('label'=>t('System'), 'url'=>array('/besettings/system')),
                                                         
                                                        ),
                                                            'visible'=>user()->isAdmin ? true : false,   
                                                        )
					
				),
			)); ?>
		
		</div>
		<div id="main-content-zone">
                        <?php if(isset($this->menu)) :?>
                        <?php if(count($this->menu) >0 ): ?>
			<div class="header-info">
				<?php
                                       
                                        $this->widget('zii.widgets.CMenu', array(
                                                'items'=>$this->menu,
                                                'htmlOptions'=>array(),
                                        ));
                                       
                                ?>
			</div>
                        <?php endif; ?>
                        <?php endif; ?>
			<div class="page-content">                                
                                <h2><?php echo (isset($this->titleImage)&&($this->titleImage!=''))? '<img src="'.$backend_asset.'/'.$this->titleImage.'" />' : ''; ?><?php echo isset($this->pageTitle)? $this->pageTitle : '';  ?></h2>
                                <?php if (isset($this->pageHint)&&($this->pageHint!='')) : ?>
                                    <p><?php echo $this->pageHint; ?></p>
                                <?php endif; ?>
				<?php echo $content; ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>

</div><!-- page -->
    <script type="text/javascript">

	$(document).ready(function () {
            //Hide the second level menu
            $('#left-sidebar ul li ul').hide();            
            //Show the second level menu if an item inside it active
            $('li.list_active').parent("ul").show();
            
            $('#left-sidebar').children('ul').children('li').children('a').click(function () {                    
                
                 if($(this).parent().children('ul').length>0){                  
                    $(this).parent().children('ul').toggle();    
                 }
                 
            });
          
            
        });
    </script>
</body>

</html>