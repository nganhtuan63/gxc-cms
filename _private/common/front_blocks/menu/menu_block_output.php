<div class="nav">
<div class="inner_nav">	
<table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="active">
                    	<a href="#" title="women">women</a>
                    </td>
                    <td>
                    	<a href="#" title="men">men</a>
                    </td>
                    <td>
                    	<a href="#" title="kid">kid</a>
                    </td>
                    <td>                   
                    	<a href="#" title="bags">bags</a>
                    </td>
                    <td>
                    	<a href="#" title="accessories">accessories</a>
                    </td>
                    <td>
                    	<a href="#" title="top hit">top hit</a>
                    </td>
                    <td class="last">
                    	<a href="#" title="newly updated">newly updated</a>
                    </td> 
                  </tr>
                </table> 
<div class="userLogin">
    <?php if(!user()->isGuest) : ?>
    <a href="javascript:void(0;)" onClick="return toggleMenuUser();" class="userinfo" title="username" id="usermenu-button"><img onClick="return toggleMenu();" class="head_avatar" src="<?php echo GxcHelpers::getUserAvatar('23',user()->getModel()->avatar,$this->layout_asset.'/images/avatar_23.png');?>" /><span class="head_username"><?php echo user()->getModel()->display_name; ?></span></a>    	
    	<ul class="dropdownmenu" id="usersubmenu">
        <li><a href="<?php echo bu();?>/dashboard"><?php echo t('Dashboard'); ?></a></li>
        <li><a href="<?php echo bu();?>/profile"><?php echo t('Your Profile'); ?></a></li>
        <li><a href="<?php echo bu();?>/saved-searchs"><?php echo t('Saved Searchs'); ?></a></li>
        <li><a href="<?php echo bu();?>/user/logout"><?php echo t('Sign out'); ?></a></li>
    	</ul>        
      <script type="text/javascript">       
        $('#usersubmenu').hide();                      
        function toggleMenuUser(){        	        	
        	    $('#usersubmenu').toggle();
        	    return false;
        }
     </script>
    <?php else : ?>
    <a href="<?php echo bu();?>/sign-in" class="userinfo" title="signin" style="background: none; padding:0px 5px">Sign in</a>
    <?php endif; ?>   
</div>
<div class="clear"></div>  
</div>    
</div>