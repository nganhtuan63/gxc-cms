<?php

class Parse{
    
        public static function parsePagesInQueue(){
            
                $list_parse_queue=ParseQueue::model()
                        ->with(
                        array(
                             'brand_parent'=>array('condition'=>'brand_allow_parse='.OsgConstantDefine::BRAND_ALLOW_PARSE)                                                            
                            ,'brand_page_parent'=>array('condition'=>'bp_allow_parse='.OsgConstantDefine::BRAND_ALLOW_PARSE)
                            ))->findAll(
                        array('select'=>'*, rand() as rand',
                                  'limit'=>OsgConstantDefine::LIMIT_PARSE_PER_TIME,
                                  'order'=>'rand',
                                  'condition'=>'ppq_status = '.OsgConstantDefine::PARSE_ON_WAIT
                                  ));
                
                if($list_parse_queue && count($list_parse_queue)>0){
                    
                    
                        //Start to fetch the data based on the params of Brand Page
                    
                        $klog = new KLogger(Yii::getPathOfAlias('common.log').DIRECTORY_SEPARATOR.'parse_log', KLogger::INFO);
                        foreach($list_parse_queue as $parse_queue){
                                                                
                                //We first get File from the Fetch Data Folder
                                $file=COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$parse_queue->ppq_filename;
                                                                
                                //Use PhpQuery to read it
                                phpQuery::newDocumentFileHTML($file);
                                                                
                                //Get all availabe for current fetch
                                $brand_fetchs=  ProductFetch::model()->findAll('pf_brand_id = :bid',array(':bid'=>$parse_queue->ppq_brand_id));
                                
                                //Set product list
                                $sale_products_list=array();
                                                                                             
                                $error_list = array();
                                                                
                                //With each fetch style, we will try to look for Sale Item
                                foreach($brand_fetchs as $fetch_params){                                                                    
                                    
                                    /* Required Params */
                                    //$params=unserialize($parse_queue->brand_page_parent->bp_params);                              
                                    
                                    $params['brand']=$parse_queue->brand_parent->brand_for_parse;
                                    $params['site']=$parse_queue->brand_parent->brand_site;
									$params['site_url']=$parse_queue->brand_parent->brand_site;
                                    $params['page_url']=$parse_queue->brand_page_parent->bp_url;
                                                                         
                                    $params['product_wrapper']= $fetch_params->pf_wrapper;
                                    $params['product_template']=$fetch_params->pf_template;

                                    $params['paging_wrap']=$fetch_params->pf_paging_wrap;
                                    $params['onsite_id']=$fetch_params->pf_onsite_product_id;

                                    //Set the current page params
                                    $params['current_page']=$parse_queue->ppq_page_number;
                                    
                                    
                                    if(!$parse_queue->brand_parent->brand_mix){
                                        $items_name = array('osg_sale_price','osg_image','osg_name','osg_regular_price');
                                    } else {
                                        $items_name = array('osg_sale_price','osg_image','osg_name','osg_regular_price','osg_brand_name');
                                    } 
                                    //case <a> is not product_wrapper, add osg_link
                                    if (!self::aAsProductWrapper($params['product_wrapper'])) {
                                        $items_name[] = 'osg_link';
                                    }                                                                        
                                                                                                            
                                    foreach(pq($params['product_wrapper']) as $li){
                                   
                                        //Parse basic info
                                        $params['li']=$li;
                                        $html = pq($params['li'])->html();
        
                                        $sale_product=array();
                                        
                                        $on_sale=true;
                                                                               
                                        
                                                                               
                                        foreach ($items_name as $item_name) {
                                            $sale_product[$item_name] = NewItemParse::getItem(trim($html), trim($params['product_template']), trim($params['brand']), $item_name);

                                            if ($sale_product[$item_name] == null || $sale_product[$item_name] == false) {                        
                                                $on_sale = false;
                                                break;
                                            } 
                                            if (!isset($error_list[$item_name])) 
                                                $error_list[$item_name] = $sale_product[$item_name].' -- Fetch ID : '.$fetch_params->pf_id;
                                        }
                                      
                                        //case <a> is product_wrapper, get link by attribute href of wrapper
                                        if ((self::aAsProductWrapper($params['product_wrapper']))) {
                                            $sale_product['osg_link'] = pq($params['li'])->attr('href');
                                        }
                                        
                                        
                                       

                                        //dump($sale_product);

                                        if ($on_sale)  {
                                            $sale_product['osg_link']=InternetCombineUrl($params['page_url'],$sale_product['osg_link']);
                                            $sale_product['osg_image']=trim(InternetCombineUrl($params['page_url'],$sale_product['osg_image']));
                                            //$sale_product['osg_onsite_id']=NewItemParse::getItemOnSiteId($params,$sale_product['osg_link']);                        
                                            $sale_product['osg_onsite_id']='';     
                                            $sale_product['osg_sale_percent']=(100-(round($sale_product['osg_sale_price']/$sale_product['osg_regular_price']*100)));
                                            $sale_product['expired_date']=time() + ($fetch_params->expired * 86400);
                                            $sale_product['osg_brand_id']=$parse_queue->brand_parent->brand_id;
                                            
											$sale_product['html_detail_id']=isset($fetch_params->pf_detail_html_id) ? $fetch_params->pf_detail_html_id : '' ;
                                            if(!$parse_queue->brand_parent->brand_mix){
                                                $sale_product['osg_brand_name_id']=$parse_queue->brand_parent->brand_id;
                                                $sale_product['osg_brand_name']=$parse_queue->brand_parent->brand_name;
                                            } else {
                                                // So this is a Mix Brand store, we will try to look for if the brand found 
                                                // on this item belong to any existed brand before ?
                                                $brand_existed=Brand::model()->find('LOWER(brand_name)=?',array(strtolower($sale_product['osg_brand_name'])));
                                                if($brand_existed){
                                                    $sale_product['osg_brand_name_id']=$brand_existed->brand_id;
                                                } else {
                                                    $new_brand = new Brand;
                                                    $new_brand->brand_name=$sale_product['osg_brand_name'];
                                                    $new_brand->brand_slug=toSlug($sale_product['osg_brand_name']);
                                                    $new_brand->brand_created=$new_brand->brand_updated=time();
                                                    $new_brand->brand_for_parse=$new_brand->brand_name;
                                                    $new_brand->brand_affiliate = '';                                                
                                                    $current_last_crawled=time()+(2*60);
                                                    $next_crawled=$current_last_crawled+(60*60*24*3);
                                                    $new_brand->brand_last_crawled=time()+(2*60);
                                                    $new_brand->brand_next_crawl=$next_crawled;
                                                    
                                                    if($new_brand->save()){
                                                        $sale_product['osg_brand_name_id']=$new_brand->brand_id;
                                                    }
                                                    
                                                }
                                            }

                                            $sale_products_list[]=$sale_product;                              
                                        }
                                                                                   
                                    }
                                }
                                
                               
                                
                                //Parse Pages, know the current, add the next page to crawl Queue
                                $next_page = NewItemParse::getPaging($params);
								
                                    if($next_page){
                                    	                           
                                        //Add to Crawl Queue                                        
                                        //Need to check if there is a page of that brand page and new number in
                                        // the crawl queue or not
                                        $find_next_page=CrawlQueue::model()
                                        ->find('pcq_brand_page_id = :brand_page_id and
                                                pcq_page_number = :next_page',array(':brand_page_id'=>$parse_queue->ppq_brand_page_id,
                                                                                    ':next_page'=>$next_page['number']));
                                        
                                        //If no find next page
                                        if(!$find_next_page){
                                                $crawl_queue = new CrawlQueue;
                                                $crawl_queue->pcq_brand_id=$parse_queue->ppq_brand_id;
                                                $crawl_queue->pcq_brand_page_id=$parse_queue->ppq_brand_page_id;
                                                $crawl_queue->pcq_link=$next_page['link'];
                                                $crawl_queue->pcq_status=OsgConstantDefine::CRAWL_STATUS_ON_WAIT;
                                                $crawl_queue->pcq_crawl_as_root=OsgConstantDefine::CRAWL_AS_NORMAL;
                                                $crawl_queue->pcq_created=$crawl_queue->pcq_last_crawled=time();
                                                $crawl_queue->pcq_page_number=$next_page['number'];
                                                $crawl_queue->save();
                                        } else {
                                                
                                                //If next page is on wait, just update its link
                                                if($find_next_page->pcq_status==OsgConstantDefine::CRAWL_AS_NORMAL){
                                                        $find_next_page->pcq_link=$next_page['link'];
                                                        $find_next_page->save();
                                                } 
                                        }
                                    }
                                    
                                      
                                 if (!(isset($sale_products_list)) || count($sale_products_list) <=0) {
                                     
                                     //Found no Sale Items, Check for Errors
                                    $result='';
                                    if (count($error_list)>0) {
                                        
                                        $result='ERROR : Some good items';
                                        foreach ($error_list as $key=>$value) {
                                            $result.=$key .' : '.$value;
                                        }     
                                        $result.='Please check template at :';
                                        foreach ($items_name as $item_name) {
                                            if (!array_key_exists($item_name,$error_list)) {
                                                $result.=$item_name;
                                                break;
                                            }                           
                                        }
                                    }
                                    else {
                                        $result.='Please check page url again, no sale item found or error at osg_sale_price!';
                                    }
                                    $parse_queue->ppq_status=OsgConstantDefine::PARSE_NOT_FOUND;                                        
                                    $klog->LogInfo('PARSE NOT FOUND - Brand Id : '.$parse_queue->brand_parent->brand_id.' Brand Name : '.$parse_queue->brand_parent->brand_name.' Page URL : '.$parse_queue->brand_page_parent->bp_url. $result);
                                } else {
                                    
                                    //Ok, Here we found some Sale Items
                                    $parse_queue->ppq_status=OsgConstantDefine::PARSE_FOUND;
                                    $klog->LogInfo('PARSE FOUND - Brand Id : '.$parse_queue->brand_parent->brand_id.' Brand Name : '.$parse_queue->brand_parent->brand_name.' Page URL : '.$parse_queue->brand_page_parent->bp_url);
                                    
                                    foreach($sale_products_list as $sale_product){
                                         $product_id=null;
										 $product_name='';

                                            // First to search in the ObjectSale database for the Product with
                                            // the same brand, same name, same link
                                            $find_object=ObjectSale::model()->find('obj_brand_id = :brand_id
                                                                                       and object_name = :obj_name
                                                                                       and obj_link = :obj_link',
                                                                                       array(':brand_id'=>$sale_product['osg_brand_id'],
                                                                                             ':obj_name'=>$sale_product['osg_name'],
                                                                                             ':obj_link'=>$sale_product['osg_link']));
                                            
                                            // THis is not good because Object can have other different types
                                            if($find_object){
                                                
                                                    // So there is already the item in the Database, we will                                                 
                                                    // update both ObjectSale and Object table
                                                    
                                                    // Find the Object related to this ObjectSale
                                                    //$temp_object=Object::model()->findByPk($find_object->object_id);  
                                                    
                                                   // var_dump('Object Sale '.$find_object->guid);
                                                    $temp_object=Object::model()->find('guid = :guid',array(':guid'=>$find_object->guid));
                                                    
                                                    Parse::setValueForObjectSale($find_object, $sale_product, true);
                                                    $find_object->save();
                                                    
                                                    if($temp_object){
                                                        Parse::setValueForObjectSale($temp_object, $sale_product, false);
                                                        $temp_object->save();
                                                    } else {
                                                    	 $temp_object=new Object;
														 $temp_object->guid=$find_object->guid;
                                                    	 Parse::setValueForObjectSale($temp_object, $sale_product, false);
                                                   		 $temp_object->save();
                                                    }
													
													$product_id=$temp_object->object_id;
													$product_name=$temp_object->object_name;
													
                                                    													
													
												//	var_dump('Object '.$temp_object->guid. "<br />");
                                            } else {
                                                
                                                    $object_sale = new ObjectSale;                                                          
                                                    
                                                    Parse::setValueForObjectSale($object_sale, $sale_product, true);
                                                    $object_sale->save();
                                                  
                                                    $temp_object_new = new Object;
                                                    $temp_object_new->guid=$object_sale->guid;
                                                    
                                                    Parse::setValueForObjectSale($temp_object_new, $sale_product, false);
                                                    $temp_object_new->save();
                                                                                                        
                                                    $product_id=$temp_object_new->object_id;
													$product_name=$temp_object_new->object_name;
                                            }
                                            
                                            //Get the model of current term of
                                            $current_brand_term=Term::model()->findbyPk($parse_queue->brand_page_parent->bp_term_id);
                                            if($current_brand_term && $product_id){
                                                
                                                    $arr_terms=array();
                                                    $array_terms_cache=Yii::app()->cache->get('brand-page-id'.$parse_queue->ppq_brand_page_id.'-term-'.$parse_queue->brand_page_parent->bp_term_id);
													
													                                                    
                                                    if($array_terms_cache===false)
                                                    {
                                                     
                                                        $arr_terms[]=(int)$current_brand_term->term_id;
                                                        //First get all the category that this product may belongs to
                                                        $parent_term=(int)$current_brand_term->parent;

														//Count the level of the Term
														$count_level_term=0;
                                                        if($parent_term!=0){
                                                                while($parent_term!=0){
                                                                        $arr_terms[]=$parent_term;
																		
                                                                        //Get the parent terms details
                                                                        $parent_model_term=Term::model()->findbyPk($parent_term);
                                                                        if($parent_model_term){
                                                                                $parent_term=(int)$parent_model_term->parent;
                                                                        } else {
                                                                                $parent_term=0;
                                                                        }


                                                                }
                                                        }
														                                                       
                                                        //Set cache for 12 hours
                                                        Yii::app()->cache->set('brand-page-id'.$parse_queue->ppq_brand_page_id.'-term-'.$parse_queue->brand_page_parent->bp_term_id, $arr_terms, 21600);
                                                    } else {
                                                        $arr_terms=$array_terms_cache;
                                                    }
                                                    

                                                   // Update the Category for the Product

													$array_terms_sub_cache=false;
												   //Check if arr_terms has enough 3 categories 
												   
												   //The Bags doesn't has 3 categories
												   if ((($current_brand_term->parent!=0)&&(count($arr_terms)<3))
												   		||(($current_brand_term->parent==0))&&(count($arr_terms)<2))
												   {
												   		//Get the term to look for sub terms												   																
														//Get Children of the Term
														$array_terms_sub_cache=Yii::app()->cache->get('terms-sub-'.$parse_queue->brand_page_parent->bp_term_id);
														
														
																							
														if($array_terms_sub_cache===false){															
															$array_terms_sub_cache=Term::model()->findAll(array('condition'=>'parent=:parent_id','order'=>'t.order ASC','params'=>array(':parent_id'=>$parse_queue->brand_page_parent->bp_term_id)));
															if($array_terms_sub_cache){
																Yii::app()->cache->set('terms-sub-'.$parse_queue->brand_page_parent->bp_term_id,$array_terms_sub_cache,21600);
															} 
														} 
														
												   }
												   
												   if($array_terms_sub_cache) {
												   		$term_to_add_to=$array_terms_sub_cache[0]->term_id;
												
												   		foreach($array_terms_sub_cache as $sub_term){
												   			$name_to_look=explode(' ',strtolower($sub_term->name));
															$name_to_look_first=$name_to_look[0];
															$name_to_look_first=substr($name_to_look_first, 0, strlen($name_to_look_first)-1);															
															if(strpos(strtolower($product_name),$name_to_look_first)){																
																$term_to_add_to=$sub_term->term_id;																
																break;
															}
												   		}
														
													
														$arr_terms[]=$term_to_add_to;													 
												   }
                                                   
                                                   
                                                   //Start to update
                                                   foreach($arr_terms as $term_product){
                                                            $find_terms=  ObjectTerm::model()
                                                            ->find('object_id = :obj_id
                                                                    and term_id = :term_id
                                                                   ',array(':obj_id'=>$product_id,
                                                                           ':term_id'=>$term_product));
                                                            if(!$find_terms){
                                                                    $object_term=new ObjectTerm;
                                                                    $object_term->object_id=$product_id;
                                                                    $object_term->term_id=$term_product;                                                                  
                                                                    $object_term->save();
                                                            }
                                                    }

                                            }
                                    }
                                           

                                }
                                                                    
                               $parse_queue->ppq_last_parsed=time();
                               $parse_queue->save();
                        }
                   
                }
                
                
        }
        
        public static function setValueForObjectSale(&$find_object,$sale_product,$is_object_sale=true){
            $find_object->object_name=$sale_product['osg_name'];
           

            $find_object->object_excerpt
            =$find_object->object_description
            =$find_object->object_title
            =$find_object->object_keywords                                                    
            =$find_object->object_content
            =$sale_product['osg_name'];
         

            $find_object->object_slug
            =toSlug($sale_product['osg_name']);


            $find_object->total_number_meta=1;
            $find_object->total_number_resource=1;


            $find_object->object_author_name='Bot';


            $find_object->object_status= ConstantDefine::OBJECT_STATUS_PUBLISHED;

            if($is_object_sale){
            	$find_object->obj_detail_html_id=$sale_product['detail_html_id'];
                $find_object->obj_brand_id=$sale_product['osg_brand_id'];
                $find_object->obj_brand_name=$sale_product['osg_brand_name'];
                $find_object->obj_brand_name_id=$sale_product['osg_brand_name_id'];
                $find_object->obj_regular_price=$sale_product['osg_regular_price'];
                $find_object->obj_sale_price=$sale_product['osg_sale_price'];
                $find_object->obj_sale_percent=$sale_product['osg_sale_percent'];
                $find_object->obj_link=$sale_product['osg_link'];
                $find_object->obj_image=$sale_product['osg_image'];
                $find_object->obj_onsite_id=$sale_product['osg_onsite_id'];
                $find_object->obj_expired= $sale_product['expired_date'];
            }

            
            
            
            
           
        }
        
 
        
 
        public static function parseTestFetch($filename,$params){                    
            
            $result='';
            phpQuery::newDocumentFileHTML($filename);
            //Remember to always check if there is sale first
            
            $items_name = array('osg_sale_price','osg_image','osg_name','osg_brand_name','osg_regular_price');
            //$items_name = array('osg_image');
            
            //if osg_brand_name not exists, remove from array
            if (strpos($params['product_template'], 'osg_brand_name')===false)
				$items_name = array('osg_sale_price','osg_image','osg_name','osg_regular_price');
            
            //case <a> is not product_wrapper, add osg_link
            if ((!self::aAsProductWrapper($params['product_wrapper']))) {
                $items_name[] = 'osg_link';
            }
            
            $sale_products_list=array();
                           
            $error_list = array();
            foreach(pq($params['product_wrapper']) as $li){
                $params['li']=$li;
                

                $sale_product=array();
                $html = pq($params['li'])->html();
                
                $on_sale = true;
                foreach ($items_name as $item_name) {
                    $sale_product[$item_name] = NewItemParse::getItem(trim($html), trim($params['product_template']), $item_name, $params['brand'], false);
                    
                    if ($sale_product[$item_name] == null || $sale_product[$item_name] == false) {                        
                        $on_sale = false;
                        break;
                    } 
                    if (!isset($error_list[$item_name])) 
                        $error_list[$item_name] = $sale_product[$item_name];
                }
                
                //case <a> is product_wrapper, get link by attribute href of wrapper
                if (self::aAsProductWrapper($params['product_wrapper'])) {
                    $sale_product['osg_link'] = pq($params['li'])->attr('href');
                }
                
                //dump($sale_product);
                
                if ($on_sale)  {
                    $sale_product['osg_link']=InternetCombineUrl($params['site_url'],$sale_product['osg_link']);
                    $sale_product['osg_image']=trim(InternetCombineUrl($params['page_url'],$sale_product['osg_image']));
                    $sale_product['osg_onsite_id']=NewItemParse::getItemOnSiteId($params,$sale_product['osg_link']);                        
                    
                    $sale_products_list[]=$sale_product;                              
                }
                
                    
                $next_page=NewItemParse::getPaging($params);
                
                 
            }
            
            
            
            if(isset($next_page))
                $result.= "<b style='color:red'>Next page is</b> : page ".$next_page['number'].' and its link is : <a href="'.$next_page['link'].'">'.$next_page['link'].'</a>';
            
            $result.='<br /><br /><b style="color:red">List of the Products</b> <br />
            <ul style="margin:0; padding:0">';
            
            if (!(isset($sale_products_list)) || count($sale_products_list) <=0) {
                if (count($error_list)>0) {
                    $result.='<br/>Error, here are some good parse items:';
                    foreach ($error_list as $key=>$value) {
                        $result.='<br/><strong>'.$key.' : '.$value.'</strong>';
                    }     
                    $result.='<br/><br/>Please check template at :';
                    foreach ($items_name as $item_name) {
                        if (!array_key_exists($item_name,$error_list)) {
                            $result.='<br/><font style="color:red">'.$item_name.'</font>';
                            break;
                        }                           
                    }
                }
                else {
                    $result.='<br/><strong>Please check page url again, no sale item found or error at osg_sale_price!</strong>';
                }                
            }
            
            foreach($sale_products_list as $s){
                    $str='<li>';
                    if($s['osg_sale_price']!=0){
                               $str.='<span style="color:red"><b> Name is : </b>'.$s['osg_name'].'</span><br />';
                    } else {
                               $str.='<b> Name is : </b>'.$s['osg_name'].'<br />';
                    }
                    if (array_key_exists('osg_brand_name',$items_name)) {
                    	$str.='<b> Brand name is : </b>'.$s['osg_brand_name'].'<br />';
					}
                    $str.='<b> Link is : </b>'.$s['osg_link'].'<br />';                    
                    $str.='<img width="100" src="'.$s['osg_image'].'" /> <br />';
                    //$str.='<b> Sale note : </b>'.$s['sale_note'].'<br />';
                    $str.='<b> Regular : </b>'.$s['osg_regular_price'].'<br />';
                    $str.='<b> On Sale Price : </b>'.$s['osg_sale_price'].'<br />';
                    //$str.='<b> Product ID : </b>'.$s['osg_onsite_id'].'<br />';
                    $str.='------------------------------<br />';
                    $str.='</li>';
                    $result.=$str;
            }
         
            $result.="</ul>";
    
            return $result;
        }
        
        public static function aAsProductWrapper($productWrapper) {
        	return (substr($productWrapper,0,1) === 'a' || strpos($productWrapper,' a')!==false);
        }
        
        
}