	
    <div style="float:left; width:17%">                                               
            <img style="float:none; margin-bottom:10px" src="<?php echo GxcHelpers::getUserAvatar('96',user()->getModel()->avatar,$this->layout_asset.'/images/avatar.png');?>" class="avatar profile_photo"/>                    
            <h1 style="font-size:20px; margin-bottom:0px"><?php echo user()->getModel()->display_name;?></h1>
            <p><a href="<?php echo bu();?>/profile" style="color:#CC0864"><?php echo t('Thay đổi thông tin');?></a></p>                               
    </div>
    <div style="float:left; width:83%">
        <?php $this->render('cmswidgets.views.notification_frontend'); ?>
        
        <?php if(user()->getModel()->confirmed!='1') : ?>
        <div style="padding:14px; margin-bottom:10px" class="infoMessage font14">
            <h2 class="infoTitle">Welcome, <?php echo user()->getModel()->display_name;?></h2>
            <p>Thank you for being with us on OnSaleGrab. Here are some tips for getting started...</p>            
            <h2 class="infoTitle">Confirm your email</h2>
            <ul class="p-list">
                <li>You would receive a welcome email from us shortly. Please take a second to follow the link within to confirm your account</li>
                <li>Account confirmation is required for certain features like newly-found products notification, search history,...</li>
            </ul>                     
             <h2 class="infoTitle">What's next?</h2>
             <ul class="p-list">
                  <li><a target="_blank" href="<?php echo FRONT_SITE_URL;?>/profile">Customize your profile</a></li>
                  <li><a target="_blank" href="<?php echo FRONT_SITE_URL;?>/about-us">Learn how this site works</a></li>
                  <li><a target="_blank" href="<?php echo FRONT_SITE_URL;?>">Start exploring</a></li>
                
            </ul>
                                        
        </div>
         <?php endif; ?>
        <div class="zone-info">
            <a href="#">
                Recent Items
            </a>
        </div>
        
       <div class="zone-info">
            <a href="#">
                Your Favorites
            </a>
        </div>
    </div>
    <div class="clear"></div>
    
