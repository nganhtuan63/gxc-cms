<div class="bleft">
    <div class="frmSearch">
        <div class="search">
            <img src="<?php echo $this->layout_asset.'/images/dummy.gif'; ?>" alt="" class="inp"/>
            <input class="initSearch" type="text" rel="What are you looking for ?" value="What are you looking for ?" name="search" id="src_search"/>
            <button type="submit" value="" name="search" id="btnSearch"></button>
        </div>
    </div>
</div>
                
 <script type="text/javascript">
    $("#src_search").live("blur", function(){
    var default_value = $(this).attr("rel");
    if ($(this).val() == ""){
        $(this).val(default_value);
    }
    }).live("focus", function(){
        var default_value = $(this).attr("rel");
        if ($(this).val() == default_value){
            $(this).val("");
        }
    }).bind("keydown", function(event) {
          // track enter key
          var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
          if (keycode == 13) { // keycode for enter key         
             $('#btnSearch').click();
             return false;
          } else  {
             return true;
          }
       });
   $('#btnSearch').click(function(){
       var str = $('#src_search').val();
       str=jQuery.trim(str);
       str= str.replace(/\s+/g,"+");       
       if (str=='')
        alert('Oops! You forgot typing a keyword');
       else
        window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/search/'+str;
   });
 </script>            