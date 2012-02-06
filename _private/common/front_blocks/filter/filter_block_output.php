<div class="contentFunction">
	<div class="blockItemFunction" style="padding-left:0px; padding-top:3px">
   	<button href="#" type="button" class="ux-button save" role="button"><img  alt="" src="<?php echo $this->layout_asset.'/images/dummy.gif'; ?>" style="margin-right:7px" /><span class="ux-button-content">Save this search</span></button>
   	</div>
    
    <div class="blockItemFunction" id="filtercat">
        <h3><?php echo t('CATEGORIES','front');?></h3>         
       
        <div class="blockLine">
	        <ul>
	                <?php            
	                	if (isset($_GET['_escaped_fragment_']))
	                    	echo OsgConstantDefine::getCategories($arr);
	                ?>
	        </ul>
        </div>
    </div> <!-- end blockItemFunction -->
    <div class="blockItemFunction" id="filtersale">
        <h3><?php echo t('SALES OFF','front');?></h3>
        <div class="blockLine">
        <ul>
                <?php
                	if (isset($_GET['_escaped_fragment_']))            
                    	echo OsgConstantDefine::getSales($arr);
                ?>
        </ul>
        </div>
    </div>
    <div class="blockItemFunction" id="filterprice">
        <h3><?php echo t('PRICES','front');?></h3>
        <div class="blockLine">
        <ul>
                <?php            
                    if (isset($_GET['_escaped_fragment_']))
                    	echo OsgConstantDefine::getPrices($arr);
                ?>
        </ul>
        </div>
    </div> <!-- end blockItemFunction --> 
    <div class="blockItemFunction" id="filtercolor">
        <h3><?php echo t('COLORS','front');?></h3>
        <div class="blockLine">
        <ul class="lstColor color">
        	<?php            
            	if (isset($_GET['_escaped_fragment_']))
            		echo OsgConstantDefine::getColors($arr);
            ?>            
        </ul>
        </div>
    </div> <!-- end blockItemFunction -->
    <div class="blockItemFunction" id="filterbrand">
        <h3><?php echo t('DESIGNERS','front');?></h3> 
        <input type="text" class="input01" id="findDesigner" value="find a designer" rel="find a designer">
        <p>select one or more designers</p>
        <div class="blockBrand" style="height:250px; overflow-x: hidden; overflow-y: auto">
	        <ul>
	                <?php            
	                    if (isset($_GET['_escaped_fragment_']))
	                    	echo OsgConstantDefine::getBrands($arr);
	                ?>
	        </ul>
	    </div>
    </div> <!-- end blockItemFunction -->

</div> <!-- end contentFunction -->
    <script>          
            var linkAjax = 'ajax?type=items';
            var linkFilter = 'ajax?type=filter';
            var cacheFilter = {'default':''};
            var cacheContent = {'default':''};
            
            function buildSelection(values) {
            	var selection;
            	for (index in values) {
            		selection = values[index];            		
            		$('.blockL:first').append('<p name="sel'+selection['name']+'"><span class="uiButton" > <a href="'+selection['param']+'" class="btn"><img src="<?php echo $this->layout_asset."/images/dummy.gif";?>" class="btn btLeft" alt="" />'+selection['description']+'<img src="<?php echo $this->layout_asset."/images/dummy.gif";?>" class="btn btRight" alt="" /></a> </span></p>');	
            	}
			}
			
			function buildFilter(type, values) {
				var selection;
				$('#filter'+type).find('ul').empty();
				for (index in values) {
            		selection = values[index];
            		if (type=='color') 
            			$('#filtercolor').find('ul').append('<li class="'+selection['name']+selection['select']+'"><a name="'+type+selection['id']+'" href="'+selection['url']+'" '+ selection['select']+' title="'+selection['name']+'"><em></em><span></span></a></li>');
            		else
            			$('#filter'+type).find('ul').append('<li><a name="'+type+selection['id']+'" href="'+selection['url']+'" '+ selection['select']+' title="'+selection['name']+'">'+selection['name']+'</a></li>');	
            	}	
			}
			
            function buildLabel() {
				var label = 'All items';
				if ($('p[name^="sel"]').length > 0) {
					//get category
					var cat = $('p[name^="selcat"]').find('a').text();
					var color='';
					if ($('p[name^="selcolor"]').length == 1){
						color = $('p[name^="selcolor"]').find('a').text();
					}
					var brand='';
					if ($('p[name^="selbrand"]').length == 1){
						brand = $('p[name^="selbrand"]').find('a').text();
					}
					var sale='';
					if ($('p[name^="selsale"]').length == 1){
						sale = ' from '+$('p[name^="selsale"]').find('a').text();
					}
					label = color+' '+brand+' '+cat+' '+' Items'+sale;
					if (label.trim()=='items')
						label='Selected items';	
				}
				$(".highLight01 h1").html(label);	
			}
			
            $('.blockItemFunction a, .blockTop01 a').live('click', function(e) {
				var href = $(this).attr('href');
				var pos = href.indexOf('#!');
				if(pos >= 0) {
					var state = href.substr(pos);
					$.bbq.pushState(state);
					return false;
				}
			});

            $(window).bind( 'hashchange', function(e) {
				var param = '';
				var hash = '';
				if (typeof e.fragment!='undefined')
					hash = e.fragment;
				else
					hash = window.location.hash;
				
				var pos = hash.indexOf('&');
				if (pos>0) {
					hash = hash.substr(pos+1)
					param = '?'+hash;
				}
			  	
			  	if (cacheFilter[hash] != undefined && cacheContent[hash] != undefined) {
			  		//existed in cache
			  		$('.contentFunction').html(cacheFilter[hash]);
			  		$('.blockItems').html(cacheContent[hash]);
			  		$("#findDesigner").quicksearch(".blockBrand ul li");
					return;
			  	}
			  	
			  
               
			  	$.get(linkFilter+param, function(data) {
					var filter = eval("(" + data + ")");
					for (index in filter) {											
						if (index!='select'){ 							
							buildFilter(index, filter[index]);
						}
						else {								
							$('.blockL').empty();
							if (filter[index]!='') {								
								buildSelection(filter[index]);
								$('blockTop01').show();
								buildLabel();
							}
							else {
								$('blockTop01').hide();
								$(".highLight01 h1").html('All items');
							}
						}
					}
					//save in cache
					cacheFilter[hash] = $('.contentFunction').html();
					cacheContent[hash] = $('.blockItems').html();
                
					$("#findDesigner").quicksearch(".blockBrand ul li");
				});
				
				
			});
		  	
		  	$(window).trigger( 'hashchange' );
		  	
			$('.blockItemFunction h3').click(function(){
              	$(this).next().toggle();
            });    
            
                         
    </script>