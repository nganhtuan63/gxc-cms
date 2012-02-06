<?php

function getItemName($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            default:
                return pq($params['li'])->find($params['product_name'])->html();
            break;
        }
    }
    return null;
}

function getItemLink($params=array(),$brand=''){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            default:   
                $link=pq($params['li'])->find($params['product_link'])->attr('href');
                if($link) {
                    if(strpos('http://',$link)===false){
                            if($link[0]=='/'){
                                    $link=$params['site'].$link;
                            } else {
                                    $link=$params['site'].'/'.$link;
                            }
                    }
                    return $link;
                } else {
                    return null;
                }
                
            break;
        }
    }
    return null;
}


function getItemOnSiteId($params=array(),$link,$brand=''){
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



function getItemImage($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            default:   
                return pq($params['li'])->find($params['product_image'])->attr('src');        
            break;
        }
    }
    return null;
}


function getSaleNote($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            default:   
                return pq($params['li'])->find($params['product_sale_price'])->html();        
            break;
        }
    }
    return null;
}

function getSalePrice($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            case 'levis':
                return floatval(str_replace('Now $','',pq($params['li'])->find($params['product_sale_price'])->html()));        
            break;
            default:   
                return floatval(str_replace('$','',pq($params['li'])->find($params['product_sale_price'])->html()));        
            break;
        }
    }
    return null;
}

function getRegularPrice($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){
            case 'levis':
                return floatval(str_replace('Was $','',pq($params['li'])->find($params['product_regular_price'])->html()));        
            break;
            default:   
                return floatval(str_replace('$','',pq($params['li'])->find($params['product_regular_price'])->html()));        
            break;
        }
    }
    return null;
}

function getBrand($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){            
            default:
                if(($params['product_brand'])=='')
                    return $params['brand'];
                else
                    return pq($params['li'])->find($params['product_brand'])->html();     
            break;
        }
    }
    return null;
}

function getPaging($params=array()){
    if($params['brand']){
        switch(strtolower($params['brand'])){            
            default:
                    $pages = pq($params['paging_wrap']);
                    if($pages){
                        $arr_page=array();
                        $arr_page_number=array();
                        foreach($pages as $page){
                            //Start  Regex to get number from string
                            $link_html=pq($page)->find('a:first')->html();
                            $link_value=pq($page)->find('a:first')->attr('href');
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
                            if(strpos('http://',$link)===false){
                                if($link[0]=='/'){
                                        $link=$params['site'].$link;
                                } else {
                                        $link=$params['site'].'/'.$link;
                                }
                            }
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

function get_web_page( $url )
{
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle compressed
		CURLOPT_USERAGENT      => "OnSaleGrab", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
    
        //$result = get_web_page( $url );
        //if ( $result['errno'] != 0 )
        //    ... error: bad url, timeout, redirect loop ...
        //if ( $result['http_code'] != 200 )
        //   ... error: no page, no permissions, no service ...
        //$page = $result['content'];

}