/**
 * @class: L10N
 * @description: Defines L10N functions
 * @author: GxcSolutions 
 * @version: 1.0
 **/

var L10N = {
	init: {
		search: 'What are you looking for ?',
		username: 'Username',
		password: 'pass'
	}
};

/**
 * @class: Start
 * @description:  Start website here
 * @version: 1.0 
 **/
 
/**
 * Global variables
 */
var ProjectName = ProjectName || {};
ProjectName.variable1 = 'OnSaleGrab';	

/**
 * Website start here
 **/
jQuery(document).ready(function(){	    		
		$("#findDesigner").live("blur", function(){
		        var default_value = $(this).attr("rel");
		        if ($(this).val() == ""){
		            $(this).val(default_value);
		        }
		        }).live("focus", function(){
		            var default_value = $(this).attr("rel");
		            if ($(this).val() == default_value){
		                $(this).val("");
		            }
	        	}).quicksearch(".blockBrand ul li");  
	        	
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
           $(document).bind('click',function(e){
                        var searchInput=$('#src_search');
			if(!$(e.target).hasClass('initSearch')){
				if(searchInput.attr('value') == ''){
					searchInput.attr('value',L10N.init.search);
				}
			}                        
            if((!$(e.target).hasClass('userinfo'))&&(!$(e.target).parent().hasClass('userinfo'))){
                            if($('#usersubmenu').is(':visible'))
								 $('#usersubmenu').hide();
			}
			if((!$(e.target).hasClass('sorting-button'))&&(!$(e.target).parent().hasClass('sorting-button'))){
                            if($('#sorting_options').is(':visible'))
								 $('#sorting_options').hide();
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
             
});

jQuery.fn.applyQuickView = function() {
	
	$(this).each(function() {  	      
		  $(this).mouseover(function() {		  	   
			   $(this).children('.btnQuickLook:first').show();
			});
			
			$(this).mouseout(function() {
			   $(this).children('.btnQuickLook:first').hide();
			});
    });  
    
	
  
    
};

function getUrlVars(url)
{
    var vars = [], hash;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}