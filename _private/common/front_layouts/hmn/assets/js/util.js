$(document).ready(function(){
	$('.dropdown').dropdown();
});

$.extend({
  jYoutube: function( url, size ){
    if(url === null){ return ""; }
	else {
		if (url.match('http://(www.)?youtube|youtu\.be')) {
		      	size = (size === null) ? "big" : size;
			    var vid;
			    var results;
			
			    results = url.match("[\\?&]v=([^&#]*)");
			
			    vid = ( results === null ) ? url : results[1];
			
			    if(size == "small"){
			      return "http://img.youtube.com/vi/"+vid+"/2.jpg";
			    }else {
			    	 if(size == "default"){
			      		return "http://img.youtube.com/vi/"+vid+"/default.jpg";
			      	} else
			      return "http://img.youtube.com/vi/"+vid+"/0.jpg";
			    }
		} else {
			return "";
		}
	}
  
  }
});