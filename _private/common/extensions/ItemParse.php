<?php

class ItemParse {
    public static function getItemName($params=array()){
        if($params['brand']){
            switch(strtolower($params['brand'])){
                default:
                    $res = pq($params['li'])->find($params['product_name'])->html();
                    
                    return (preg_replace('/[^a-z0-9&#;\s\.\,]/i', '', $res));
                break;
            }
        }
        return null;
    }
    
    public static function getItemLink($params=array(),$brand=''){
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
    
    
    
    public static function getItemImage($params=array()){
        if($params['brand']){
            switch(strtolower($params['brand'])){
                default:   
                    return pq($params['li'])->find($params['product_image'])->attr('src');        
                break;
            }
        }
        return null;
    }
    
    
    public static function getSaleNote($params=array()){
        if($params['brand']){
            switch(strtolower($params['brand'])){
                default:   
                    $res = pq($params['li'])->find($params['product_sale_price'])->html();
                    return (preg_replace('/[^a-z0-9&#;\s\.\,]/i', '', $res));
                break;
            }
        }
        return null;
    }
    
    public static function getSalePrice($params=array()){
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
    
    public static function getRegularPrice($params=array()){
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
    
    public static function getBrand($params=array()){
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
    
    public static function getPaging($params=array()){
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
                                $link=InternetCombineUrl($params['page_url'],$link);
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


}