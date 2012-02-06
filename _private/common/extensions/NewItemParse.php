<?php

class NewItemParse {    
    
    public static function replaceNumberInDom($html, $dom, $char='x') {
        $pattern =  "/".$dom."=\".*?\"/";           
        $pattern_num = "/[0-9]/";
        $temp = $html;
        while (preg_match($pattern,$temp,$match_result)) {
            if (preg_match($pattern_num,$match_result[0])) {
                $for_replace = preg_replace($pattern_num, $char, $match_result[0]);            
                $html = str_replace($match_result[0], $for_replace, $html);                    
            }
            $temp = str_replace($match_result[0],'', $temp);
        }
        return $html;
    }
    
    public static function debugRegex($debug, $list_debug, $id_debug, $log, $html_template, $html) {
        if ($debug && in_array($id_debug, $list_debug)) {
            //echo "<br><font color='red'>HTML Template after ".$log."</font><br>";
            //echo htmlspecialchars($html_template);
            echo "<br><font color='red'>HTML Crawled after ".$log."</font><br>";
            echo htmlspecialchars($html);
        }
    }
    
    public static function debugExplode($debug, $list_debug, $id_debug, $log, $item) {
        if ($debug && in_array($id_debug, $list_debug)) {
            echo "<br><font color='red'>".$log."</font><br>";
            echo htmlspecialchars($item);            
        }
    }
    
    public static function writeLog($message) {
        echo $message;
    }
    
    
    public static function getItem($html, $html_template, $item_name, $shop_name, $debug=false){               
        $list_debug = array('left','right','html');   
        //$list_debug = array('title_name_alt_id','comment');   
		 
        $patterns = array(
                'white_space_break_line' => array(
                            'pattern' => '/\>(\s+)\</',
                            'result' => '><',
                            'condition' => null,
                            'log' => 'Replace white space and break line',
                        ),
                'title_name_alt_id' => array(
                            'pattern' => "/(alt|id|title|name)=\".*?\"/",//"/id=\\\".*?\\\"/";
                            'result' => '',
                            'condition' => null,
                            'log' => 'Replace title, name, alt, id',
                        ),
                'comment' => array(
                            'pattern' => '/<!--(.*?)-->/',//"/id=\\\".*?\\\"/";
                            'result' => '',
                            'condition' => null,
                            'log' => 'Replace comment',
                        ),
                'href' => array(
                            'pattern' => "/href=\".*?\"/", //"/id=\\\".*?\\\"/";
                            'result' => '',
                            'condition' => array('osg_name','osg_brand_name'),   //case <a href="abc">osg_name</a>
                            'log' => 'Replace href if item_name is osg_name or osg_brand_name',
                        ),
                'style' => array(
                            'pattern' => "/style=\".*?\"/", //"/id=\\\".*?\\\"/";
                            'result' => '',
                            'condition' => array('osg_link','osg_brand_name','osg_sale_price','osg_regular_price'),   //case <a href="abc">osg_name</a>
                            'log' => 'Replace style',
                        ),
                'for_mango' => array(
                            'pattern' => "/class=\"(.*?)\"/", //"/id=\\\".*?\\\"/";
                            'shop'=>'Mango',
                            'result' => '',
                            'condition' => array('osg_name'),   //case <a href="abc">osg_name</a>
                            'log' => 'Replace for Mango',
                        ),        
                'two_white_spaces' => array(
                            'pattern' => '/(\s+)/',
                            'result' => ' ',
                            'condition' => null,
                            'log' => 'Replace two white spaces',
                        ),        
                'close_tag_space'  => array(
                            'pattern' => '/(\s+)\/\>/',
                            'result' => '>',
                            'condition' => null,
                            'log' => 'Replace close tag with space',
                        ),
                'event'  => array(
                            'pattern' => '/(onclick|onmousedown|onmouseup|onmouseout|onload|onmouseover)="(.*?)"/',
                            'result' => '',
                            'condition' => null,
                            'log' => 'Replace event',
                        ),
                'script'  => array(
                            'pattern' => '/<script>(.*?)<\/script>/',
                            'result' => '',
                            'condition' => null,
                            'log' => 'Replace script',
                        ),
                'nake_span'  => array(
                            'pattern' => '/<span>/',
                            'result' => '',
                            'condition' => null,
                            'log' => 'Replace nake span',
                        ),
                'close_tag'  => array(
                            'pattern' => '/\/\>/',
                            'result' => '>',
                            'condition' => null,
                            'log' => 'Replace close tag',
                        ),        
                'close_image'  => array(
                            'pattern' => "/\"(\s+)\>/",
                            'result' => '">',
                            'condition' =>null,
                            'log' => 'Replace close image tag',
                        ),
                'bad_a' => array(
                            'pattern' => '/\<a \>/',
                            'result' => '<a>',
                            'condition' => null,
                            'log' => 'Replace bad tag a',
                        ), 
                'bad_sign' => array(
                            'pattern' => '/\'/',
                            'result' => '"',
                            'condition' => null,
                            'log' => 'Replace \' ',
                        ),
                            
            );
        
        foreach ($patterns as $id=>$pattern) {
            if (  (($pattern['condition']==null || in_array($item_name, $pattern['condition']))
						&& !isset($pattern['shop'])) 
				||(isset($pattern['shop']) && $pattern['shop']==$shop_name && in_array($item_name, $pattern['condition']))
			   ) {
                $html_template = preg_replace($pattern['pattern'], $pattern['result'], $html_template);
                $html = preg_replace($pattern['pattern'], $pattern['result'], $html);    
                self::debugRegex($debug, $list_debug, $id, $pattern['log'], $html_template, $html);
            }   
        }
        //dump($debug);
        
        //number in class
        $html_template = self::replaceNumberInDom($html_template, 'class');
        $html = self::replaceNumberInDom($html, 'class');
        self::debugRegex($debug, $list_debug, 'class', 'Replace number in class', $html_template, $html);
		
		//number in id
        $html_template = self::replaceNumberInDom($html_template, 'id');
        $html = self::replaceNumberInDom($html, 'id');
        self::debugRegex($debug, $list_debug, 'id', 'Replace number in id', $html_template, $html);
		
		//number in name
        $html_template = self::replaceNumberInDom($html_template, 'name');
        $html = self::replaceNumberInDom($html, 'name');
        self::debugRegex($debug, $list_debug, 'name', 'Replace number in name', $html_template, $html);
                
        //WORKING WITH TEMPLATE
        //explode template to find left & right  wrapper        
        //wrapper begin with < and end with > like <a href='osg_link' />
        //left wrapper is <a href=' & right wrapper is ' />
        $str_arr = explode($item_name, $html_template);
        if (isset($str_arr) && count($str_arr)<2) { //wrong template
            self::writeLog('Wrong template, missing '.$item_name); 
            return false;
        }
        if (count($str_arr)>2) { //wrong template
            self::writeLog('Wrong template, count of '.$item_name.' > 2'); 
            return false;
        }
        self::debugExplode($debug, $list_debug, 'str_arr', 'After exploding using item_name ',$str_arr);
        
        $str_arr_first = explode('<',$str_arr[0]);                                            
        $str_arr_last = explode('>',$str_arr[1]);
        self::debugExplode($debug, $list_debug, 'str_arr', 'After exploding using item_name ',$str_arr);
        
        if (!(isset($str_arr_first) && isset($str_arr_last))) {
            self::writeLog('Wrong template, need to check '.$item_name); 
            return false;
        }
        self::debugExplode($debug, $list_debug, 'str_arr_first', 'After exploding left wrapper using < ',$str_arr_first);
        self::debugExplode($debug, $list_debug, 'str_arr_last', 'After exploding right wrapper using > ',$str_arr_last);
        
        $left = '<'.$str_arr_first[count($str_arr_first)-1];
        $right = $str_arr_last[0].'>';
        self::debugExplode($debug, $list_debug, 'left', 'Left wrapper: ',$left);
        self::debugExplode($debug, $list_debug, 'right', 'Right wrapper: ',$right);
        self::debugExplode($debug, $list_debug, 'html', 'HTML crawled: ',$html);
		
		if ((strpos($html,$left))===false) {
            //self::writeLog('No sale, need to check '.$item_name);   
            return null; //no sale
        }
        //END WORKING WITH TEMPLATE
        
            
        //WORKING WITH HTML CRAWLED    
        
        $html_arr = explode($left, $html); //foreach($html_arr as $_element) { echo 'Element:<font color="blue">'.htmlspecialchars($_element).'</font><br>';}       
        self::debugExplode($debug, $list_debug, 'html_arr', 'HTML crawled after exploding using left wrapper: ',$html_arr);
        
        //if there exists more than 1 result, filter by right wrapper, can't have '<' before
        if (count($html_arr)>1) {
            unset($html_arr[0]);
            foreach ($html_arr as $html_item) {
                $pos_right = strpos($html_item, $right);
                if ($pos_right > 0) {
                    $res = substr($html_item, 0, $pos_right);
                    if (strpos($res,'<')===false && strpos($res,'>')===false)
                        return $res;
                }
            }
        } 
        
        return null;        
    }    
    
     public static function getPaging($params=array()){
     	
			
        if($params['brand']){        	      	
        	if(substr($params['site_url'], strlen($params['site_url'])-1)!='/'){        		        		
        		$params['site_url'].='/';
        	}
						
            switch(strtolower($params['brand'])){
				case 'mango':
					 $pages = pq($params['paging_wrap'])->find('span');										 					
					  if($pages){                        	
                            $arr_page=array();
                            $arr_page_number=array();
							$next_page=null;
                            foreach($pages as $page){                            	
                            	if(strtolower(trim(pq($page)->html()))=='next'){                            		
                            		  $link_html=pq($page)->parent()->attr('href');
									  $next_page['number'] =  $params['current_page']+1;
									  $link=InternetCombineUrl($params['site_url'], $link_html);
									  $next_page['link'] =  $link;									  
									  break;
                            	}
							}
							return $next_page;
					  }
					  return null;
					  break;            
                default:
                        $pages = pq($params['paging_wrap'])->find('a');
                        if($pages){
                        	
                            $arr_page=array();
                            $arr_page_number=array();
                            foreach($pages as $page){
                            	
								//var_dump($page->attr('tag'));
                                //Start  Regex to get number from string
                                $link_html=pq($page)->html();
                                $link_value=pq($page)->attr('href');
								
								
                                if($link_html && $link_value){                                	
                                    if (preg_match('/(\d+)/', $link_html, $matches)) {
                                        $arr_page_number[]=$matches[1];
                                        $arr_page_link[]=$link_value; 
                                    }
                                }
                            }
                            $next_page=null;
                            //Get the next page
                            $position=array_search($params['current_page']+1,$arr_page_number);
                            if($position!==false){
                                $next_page['number'] =  $params['current_page']+1;
                                $link=$arr_page_link[$position];
                                $link=InternetCombineUrl($params['site_url'],$link);
                                /*
                                if(strpos('http://',$link)===false){
                                    if($link[0]=='/'){
                                            $link=$params['page_url'].$link;
                                    } else {
                                            $link=$params['page_url'].'/'.$link;
                                    }
                                }
                                */
                                $next_page['link'] =  $link;
                            }
                            return $next_page;
                            
                            //Start to know that this is 
                        } else {
                            return null;
                        }
                break;
            }
        }
        return null;
    }
    
      public static function getItemOnSiteId($params=array(),$link,$brand=''){
        if($params['brand']){
            switch(strtolower($params['brand'])){
                default:
                        $arr = parse_url($link);
                        if(isset($arr['query'])){
                            parse_str($arr['query'],$data);
                            if(isset($data[$params['onsite_id']])){
                                return $data[$params['onsite_id']];
                            }
                            return '';
                        }
                        return '';
                break;
            }
        }
        return '';
    }
}

?>