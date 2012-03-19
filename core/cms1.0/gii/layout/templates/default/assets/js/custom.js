/* 

Author: 			Stefan Vervoort
Author URI: 		http://www.divitomedia.com/

Description:		This little JavaScript library adds the standard features I need in projects.

*/


/* Suckerfish - 						http://htmldog.com/articles/suckerfish/dropdowns/ */

sfHover = function() {
	var sfEls = document.getElementById("navigation").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);


/* Add Search functionality */

function FunctionSearch(Element) {
	if (Element.value == 'Search Query') {
		Element.value = '';
		} else if (Element.value == '') {
		Element.value = 'Search Query';
		}
		return true;
	}
