<div class="website-info">
    <ul class="tabs">
        <li>
            <a rel="dashboard" href="dashboard"><?php echo t('Trang cá nhân');?></a>
        </li>
        <li>
            <a rel="profile"  href="profile"><?php echo t('Thông tin');?></a>
        </li>
        <li>
            <a rel="account"  href="account"><?php echo t('Tài khoản');?></a>
        </li>
    </ul>
    <script type="text/javascript">
        var current_url=document.URL;
        $('ul.tabs li').each(function(){
            if(current_url.toLowerCase().indexOf($(this).children('a').attr('rel'))!=-1){
                $(this).addClass('active');
            }
        });
    </script>
</div>