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
    
	    
        jQuery('#morebtn').moreButton();
	jQuery('.nav').dropDownMenu();
	jQuery('.frmSearch').initChangeText();
	jQuery('.frmLogin').initChangeText();                  
        
        var header_height=$('#header').height();             
        $('#contentFunction').css({'top':'6px'});
        if (!(navigator.userAgent.match(/Android/i) ||
                 navigator.userAgent.match(/webOS/i) ||
                 navigator.userAgent.match(/iPhone/i) ||
                 navigator.userAgent.match(/iPad/i) ||
                 navigator.userAgent.match(/iPod/i)
                 )){
                         
                $('#contentFunction').css({'height':($(window).height()-header_height)+'px'});
                $('#contentFunction').jScrollPane( {verticalGutter: 0});
                $('#blockTop').css({'top':header_height+'px'});
                
                $(window).scroll(function () { 
                    if($(window).scrollTop()>header_height){               
                       $('#blockTop').css({'position' : 'fixed','top': '0px'});
                    } else {
                       $('#blockTop').css({'position' : 'absolute','top': header_height+'px'});

                    }
                });        
                $(window).resize(function () { 
                    $('#contentFunction').css({'height':($(window).height())+'px'});
                    if($(window).scrollTop()>header_height){               
                       $('#blockTop').css({'position' : 'fixed','top': '0px'});
                    } else {
                       $('#blockTop').css({'position' : 'absolute','top': header_height+'px'});               
                    }
                    $('#contentFunction').jScrollPane({verticalGutter: 0});
                });  
                
                if($('#shFilterHidden').val()=='3'){
                    shFilter(1);
                } else {
                    shFilter($('#shFilterHidden').val());
                }
        } else {
                if($('#shFilterHidden').val()=='3'){
                    shFilter(2);
                } else {
                    shFilter($('#shFilterHidden').val());
                }
        }
        
        
                     
    
});

/**
 * @class: Util
 * @description: Defines Util functions
 * @version: 1.0
 **/
 
(function($){
	
	$.fn.initChangeText = function(options){
		var that = $(this);
		var searchInput = $('.initSearch');
		var nameInput = $('.initName');
		var passInput = $('.initPass');
		var searchWidth = $(window).width() - 750;
		var flag = false;
		searchInput.css('width',searchWidth);
		searchInput.unbind('click').bind('click',function(){
			if($(this).attr('value') == L10N.init.search){
				$(this).attr('value','');
			}
		});
		nameInput.unbind('click').bind('click',function(){
			if($(this).attr('value') == L10N.init.username){
				$(this).attr('value','');
			}
		});
		passInput.unbind('click').bind('click',function(){
			if($(this).attr('value') == L10N.init.password){
				$(this).attr('value','');
			}
		});
		$(document).bind('click',function(e){
			if(!$(e.target).hasClass('initSearch')){
				if(searchInput.attr('value') == ''){
					searchInput.attr('value',L10N.init.search);
				}
			}
			if(!$(e.target).hasClass('initName')){
				if(nameInput.attr('value') == ''){
					nameInput.attr('value',L10N.init.username);
				}
			}
			if(!$(e.target).hasClass('initPass')){
				if(passInput.attr('value') == ''){
					passInput.attr('value',L10N.init.password);
				}
			}
		});
		$(window).resize(function(){
			searchInput.css('width',$(window).width() - 750);
		});
	};
	
	$.fn.dropDownMenu = function(options_input){
		var defaults = {
			speed: 0
		};
                
		var options = $.extend(defaults, options_input);                                           
		$('#submenu').hide();
                $('.second_menu_parent').hide();                                              
                $(this).hoverIntent(                
                    function(){  
                       var object=$('#nav').find('td.is_over');                                              
                       if(object){
                            var link=$(object).find('a.first_level:first');
                               var id=$(link).attr('id');                               
                               if(id){
                                   id=id.split('_');                     
                                   $('#shade').show();
                                   $('.submenu').hide();      
                                   $('#submenu_'+id[2]).show();                                              
                                   $('.second_menu_parent_'+id[2]).show();                                   
                                   $('#showHideButton').hide();
                                     
                               }
                        }
                    },
                    function(){                        
                      $('.submenu').hide();  
                      $('#shade').hide();
                      $("td.first_level_td").removeClass('is_over');
                      $('#showHideButton').show();
                    }
            
                );
                
                
                
                $("td.first_level_td").hoverIntent(
                
                function(){
                        $("td.first_level_td").removeClass('is_over');
                        $(this).addClass('is_over');
                        var link=$(this).find('a.first_level:first');
                               var id=$(link).attr('id');                               
                               if(id){
                                   id=id.split('_');                     
                                   $('#shade').show();
                                   $('.submenu').hide();      
                                   $('#submenu_'+id[2]).show();                                              
                                   $('.second_menu_parent_'+id[2]).show(); 
                                   
                                   $('#showHideButton').hide();
                               }
                },
                
                function(){
                        $("td.first_level_td").removeClass('is_over');
                        var object=$("#nav").find($('.submenu:visible'));
                        if(object){                        
                            object.parent().addClass('is_over');
                        }
                }
            
                );
                
                $('#shade').mousemove(function(){                    
                    var object=$("#nav").find($('.submenu:visible'));
                    if(object){                        
                        object.parent().addClass('is_over');
                    }
                });
                
                $('#shade').mouseleave(function(){                    
                      $("td.first_level_td").removeClass('is_over'); 
                });              
                
                $('#hideTouch').unbind('click').bind('click',function(){
                      $('.submenu').hide();  
                      $('#shade').hide();
                      $('#showHideButton').show();
		});
               
                if( navigator.userAgent.match(/Android/i) ||
                 navigator.userAgent.match(/webOS/i) ||
                 navigator.userAgent.match(/iPhone/i) ||
                 navigator.userAgent.match(/iPad/i) ||
                 navigator.userAgent.match(/iPod/i)
                 ){
                         $('.divcloseTouch').show();
                         
                 } else {
                         $('.divcloseTouch').hide();
                 }
                    
                
		
	};
        
        $.fn.moreButton = function(options_input){		
                
                $(this).unbind('click').bind('click',function(){
                        if($('.blockMore').is(':visible')){
                                $('.blockMore').slideUp(0);
                        }
                        else{
                                $('.blockMore').slideDown(0);
                        }
                });               
                $(document).bind('click',function(e){
                        if(!$(e.target).hasClass('more')){
                                $('.blockMore').slideUp(0);
                        }
                });
        };
     
        
	
})(jQuery);