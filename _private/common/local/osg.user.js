// ==UserScript==
// @name          OsgParse
// @require       https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js
// ==/UserScript==

// Append some text to the element with id someText using the jQuery library.

var item_template='';

function DIOnMouseOver(evt)
{
	element = evt.target; 	// not IE
	
        if($(element).parents('#osg_form_div').length<=0){
            // set the border around the element
            element.style.borderWidth = '2px';
            element.style.borderStyle = 'solid';
            element.style.borderColor = '#f00';
            
            //var html_value=$(element).clone().wrap('<div>').parent().html();
            var html_value=$(element).clone();           
         
            var checked = $('input[type=radio]:checked').val() != undefined;
            var item_type=1;
            if(checked){
                var id=($('input[type=radio]:checked').val());
                
                //Remove not neccesary attr
                
                 if((id!='osg_wrapper')&&(id!='osg_paging_wrapper')){
                    $(html_value).removeAttr('id');
                 }              
                  if (element.tagName.toLowerCase()!='img'){
                      $(html_value).removeAttr('style');
                  }
                 //$(html_value).removeAttr('style');
                 $(html_value).removeAttr('rel');
                 $(html_value).removeAttr('title');
                 $(html_value).removeAttr('alt');
                 //$(html_value).removeAttr('height');
                 //$(html_value).removeAttr('width');
                 $(html_value).removeAttr('name');
                 //$(html_value).removeAttr('border');
                 
                 
                 
                if (element.tagName.toLowerCase()=='img'){
                     $(html_value).attr('src',id);
                } else {
                    if (element.tagName.toLowerCase()=='a'){
                        $(html_value).html('');
                        if(id=='osg_name'){
                             $(html_value).attr('href','');
                             $(html_value).html(id.toString());
                        } else {
                             $(html_value).attr('href',id);
                        }
                    } else {
                         if((id=='osg_wrapper')||(id=='osg_paging_wrapper')){
                             item_type=2;
                             if ($(html_value).attr('id')){
                                 $('#path_info').val(element.tagName.toLowerCase()+'#'+$(html_value).attr('id'));
                             } else {
                                 if ($(html_value).attr('class')){
                                    $('#path_info').val(element.tagName.toLowerCase()+'.'+$(html_value).attr('class'));
                                 }
                             
                             }
                             
                         } else {
                             if((id=='osg_regular_price')||(id=='osg_sale_price')){
                                var isCurrency_re    = /\d+(?:\.\d{0,2})$/;   
                                var old_html=$(html_value).html();
                                $(html_value).html('');
                                $(html_value).html(old_html.replace(isCurrency_re,id));
                             } else {
                             $(html_value).html('');
                             $(html_value).html(id.toString());
                             }
                         }
                  
                        //Other Tags
                    }
                }
                
            }
            
            if(item_type==1)
                $('#path_info').val(html_value.wrap('<div>').parent().html());
            
           
        }
	
        
}

function createForm(){    
    var form='<div id="osg_form_div" style="z-index:100000000; background:#CCC;border:1px dotted #000; position:fixed; bottom:10px; width:400px; left:10px;"><h1>Form</h1><form id="osg_form"></form><textarea style="width:400px; height:150px" id="merge_content"></textarea></div>';    
    var form_info='<div id="osg_form_div_info" style="z-index:100000000; background:#CCC;border:1px dotted #000; position:fixed; top:5px; width:100%; left:0px;"><input  style="width:100%; height:32px; background:yellow;"type="text" id="path_info" value="" /></div>';
    $('body').append(form);
    $('body').append(form_info);     
}

function addField(field,name){
    var field_html='<input style="z-index:100000000;" type="radio" name="osg_option" id="'+field+'_radio" value="'+field+'" /><b>'+name+'</b><br /><input id="'+field+'" type="text" name="'+field+'" value=""/><br />';
    $('#osg_form').append(field_html);    
}

function DIOnMouseOut(evt)
{
        if($(element).parents('#osg_form_div').length<=0){
            evt.target.style.borderStyle = 'none';
        }
}


function DIOnClick(evt)
{
	var element= evt.target;
        if($(element).parents('#osg_form_div').length<=0){
            
        }
	return false;
}


document.addEventListener("mouseover", DIOnMouseOver, true);
document.addEventListener("mouseout", DIOnMouseOut, true);
document.addEventListener("click", DIOnClick, true);

createForm();
addField('osg_wrapper','Wrapper');
addField('osg_name','Item name');
addField('osg_link','Item link');
addField('osg_regular_price','Item price');
addField('osg_sale_price','Item Sale Price');
addField('osg_image','Item Image');
addField('osg_paging_wrapper','Item Paging Wrapper');

$('#osg_wrapper_radio').attr('checked', true);

$(document).keydown(function(event) {    
    if(event.which==67){
        var checked = $('input[type=radio]:checked').val() != undefined;
            if(checked){                
                    var id=($('input[type=radio]:checked').val());
                    $('#'+id).val($('#path_info').val());
                    $('#merge_content').val('');
                    $("#osg_form input:text").each(function(){
                        if(($(this).attr('id')!='osg_wrapper')&&($(this).attr('id')!='osg_paging_wrapper'))
                            $('#merge_content').val($('#merge_content').val()+$(this).val());
                   });
                    
                }
    }
});

