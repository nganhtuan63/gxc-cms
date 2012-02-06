<?php

class Crawl{
    
        public static function crawlImages($limit=0){            
                $condition = 'select * from gxc_osg_object_sale where obj_local_image="" '.
                                    ($limit!==0 ? ' limit 0,'.$limit : '');
                $list_to_crawl = ObjectSale::model()->findAllBySql($condition);
                                
                $list_failed_object = array();
                $list_success_object = array();
                if ($list_to_crawl && count($list_to_crawl)>0){
                        $usecookie = tempnam(COMMON_FOLDER."/tmp/cookie", "CURLCOOKIE");
                
                        $curl = new CURL();
                        $opts = array(
                                CURLOPT_RETURNTRANSFER => true,     // return web page
                                CURLOPT_HEADER         => false,    // don't return headers
                                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                                CURLOPT_ENCODING       => "",       // handle compressed
                                CURLOPT_USERAGENT      => "OnSaleGrab", // who am i
                                CURLOPT_AUTOREFERER    => false,     // set referer on redirect
                                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                                CURLOPT_TIMEOUT        => 120,      // timeout on response
                                CURLOPT_MAXREDIRS      => 20,       // stop after 10 redirects
                                CURLOPT_BINARYTRANSFER => true,
                                CURLOPT_COOKIEJAR => $usecookie, 
                                CURLOPT_COOKIEFILE => $usecookie 
                        );
                
                    
                    foreach($list_to_crawl as $obj){
                        $curl->addSession($obj->obj_image,$opts);
                    }
                    $result = $curl->exec();
                    $curl->clear();
                
                
                if(!is_array($result)){
                    $temp=array();
                    $temp[]=$result;
                    $result=$temp;
                }
                
                $klog = new KLogger(Yii::getPathOfAlias('common.log').DIRECTORY_SEPARATOR.'crawl_image_log', KLogger::INFO);
                foreach($result as $key=>$value){
                    $current_object=$list_to_crawl[$key];
                    if($value){
                        $current_object=$list_to_crawl[$key];
                        $folder='brand-'.$current_object->obj_brand_id; // folder for uploaded files
                        $folder_path = IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_ORIGINAL_FOLDER.DIRECTORY_SEPARATOR.$folder;
                        if (!(file_exists($folder_path) && (is_dir($folder_path)))){
                                mkdir($folder_path,0755,true);
                        }
                        
                        $filename='brand-'.$current_object->obj_brand_id.'-origin-'.$current_object->object_id;
                        
                        $ext = CFileHelper::getExtension($current_object->obj_image);
                        if (in_array($ext,array('gif','jpg','png'))) {
                            
                            file_put_contents($folder_path.DIRECTORY_SEPARATOR.$filename.'.'.$ext,$value);
                            
                            $path_to_store = $folder.'/'.$filename.'.'.$ext;
                            //Update object
                            $current_object->obj_local_image = $path_to_store;
                            $current_object->save();    
                            $list_success_object[] = $current_object;
                            
                            $klog->LogInfo('SUCCESS CRAWL Image - For Object Id : '.$current_object->object_id.' - Name -  : '.$current_object->object_name);
                        }                                                               
                        else {
                            //add fail object to list
                            $list_failed_object[] = $current_object;   
                            $klog->LogInfo('WRONG TYPE CRAWL Image - For Object Id : '.$current_object->object_id.' - Name -  : '.$current_object->object_name);
                        }                           
                    } else {
                        //add fail object to list
                        $list_failed_object[] = $current_object;    
                        $klog->LogInfo('FAILED CRAWL Image - For Object Id : '.$current_object->object_id.' - Name -  : '.$current_object->object_name);
                    }                    
                }
            }
            return array('success'=>$list_success_object,'fail'=>$list_failed_object);                
        }
        
        
        public static function crawlPagesInQueue(){
            
                $list_crawl_queue=CrawlQueue::model()->with(array(
                                                            'brand_parent'=>array('condition'=>'brand_allow_crawl='.OsgConstantDefine::BRAND_ALLOW_CRAWL)                                                            
                                                            ,'brand_page_parent'=>array('condition'=>'bp_allow_crawl='.OsgConstantDefine::BRAND_ALLOW_CRAWL)
                                                            ))->findAll(
                        array('select'=>'*, rand() as rand',
                              'limit'=>  OsgConstantDefine::LIMIT_CRAWL_PER_TIME,
                              'order'=>'rand',
                              'condition'=>'pcq_status = '.OsgConstantDefine::CRAWL_STATUS_ON_WAIT
                              )                                       
                );
                
                
                if($list_crawl_queue && count($list_crawl_queue)>0){
                    
                    
                        $usecookie = tempnam(COMMON_FOLDER."/tmp/cookie", "CURLCOOKIE");
                
                        $curl = new CURL();
                        $opts = array(
                                CURLOPT_RETURNTRANSFER => true,     // return web page
                                CURLOPT_HEADER         => false,    // don't return headers
                                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                                CURLOPT_ENCODING       => "",       // handle compressed
                                CURLOPT_USERAGENT      => "OnSaleGrab", // who am i
                                CURLOPT_AUTOREFERER    => false,     // set referer on redirect
                                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                                CURLOPT_TIMEOUT        => 120,      // timeout on response
                                CURLOPT_MAXREDIRS      => 20,       // stop after 10 redirects
                                CURLOPT_BINARYTRANSFER => true,
                                CURLOPT_COOKIEJAR => $usecookie, 
                                CURLOPT_COOKIEFILE => $usecookie 
                        );
                
                
                    foreach($list_crawl_queue as $q){
                        $curl->addSession($q->pcq_link,$opts);
                    }
                    $result = $curl->exec();
                    $curl->clear();
                
                
                if(!is_array($result)){
                    $temp=array();
                    $temp[]=$result;
                    $result=$temp;
                }
                
                
                //Start the Log file here
                
                $klog = new KLogger(Yii::getPathOfAlias('common.log').DIRECTORY_SEPARATOR.'crawl_log', KLogger::INFO);
                foreach($result as $key=>$value){
                    $current_queue=$list_crawl_queue[$key];
                    if($value){
                        
                        $current_queue=$list_crawl_queue[$key];
                        $folder='brand-'.$current_queue->pcq_brand_id; // folder for uploaded files
                        if (!(file_exists(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder) && (is_dir(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder)))){
                                mkdir(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder,0755,true);
                        }
                     
                        $filename='brand-'.$current_queue->pcq_brand_id.'-page-'.$current_queue->pcq_brand_page_id.'-pn-'.$current_queue->pcq_page_number;
                        
                        $path=$folder.DIRECTORY_SEPARATOR.$filename;
                        
                        $value=str_replace('&','&amp;',$value);
                        file_put_contents(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$path,$value);
                        
                        //Re update that the Queue has been processed 
                        $current_queue->pcq_status=  OsgConstantDefine::CRAWL_STATUS_SUCCESS;
                    
                        //Add to the queue for Parsing
                        $parse = new ParseQueue;
                        $parse->ppq_brand_id=$current_queue->pcq_brand_id;
                        $parse->ppq_brand_page_id=$current_queue->pcq_brand_page_id;
                        $parse->ppq_filename=$path;
                        $parse->ppq_parse_root=$current_queue->pcq_crawl_as_root;
                        $parse->ppq_status= OsgConstantDefine::PARSE_ON_WAIT;
                        $parse->ppq_page_number=$current_queue->pcq_page_number;
                        $parse->ppq_created=$parse->ppq_last_parsed=time();
                        $parse->save();
                        
                        $klog->LogInfo('SUCCESS CRAWL - Brand : '.$current_queue->brand_parent->brand_name. ' Brand Page Id : '.$current_queue->pcq_brand_page_id.' - Url : '.$current_queue->pcq_link);
                        
                    } else {
                      
                        
                        //get the number failed
                        $number_failed= $current_queue->pcq_number_failed;
                        $number_failed++;
                        if($number_failed >= OsgConstantDefine::LIMIT_FAILED_CRAWL ){
                            $current_queue->pcq_status=OsgConstantDefine::CRAWL_STATUS_FAILED;
                        } else {
                            $current_queue->pcq_status=OsgConstantDefine::CRAWL_STATUS_ON_WAIT;
                        }
                        
                        $klog->LogInfo('FAILED CRAWL - Brand : '.$current_queue->brand_parent->brand_name. ' Brand Page Id : '.$current_queue->pcq_brand_page_id.' - Url : '.$current_queue->pcq_link);
                        
                        $current_queue->pcq_number_failed = $number_failed;
                    }
                    $current_queue->pcq_last_crawled=time();
                    $current_queue->save();
                    }
                }
                
        }
        
        public static function crawlTestFetch($params){
            
                
                $usecookie = tempnam(COMMON_FOLDER."/tmp/cookie", "CURLCOOKIE");
                
                $curl = new CURL();
                $opts = array(
                        CURLOPT_RETURNTRANSFER => true,     // return web page
                        CURLOPT_HEADER         => false,    // don't return headers
                        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                        CURLOPT_ENCODING       => "",       // handle compressed
                        CURLOPT_USERAGENT      => "OnSaleGrab", // who am i
                        CURLOPT_AUTOREFERER    => false,     // set referer on redirect
                        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                        CURLOPT_TIMEOUT        => 120,      // timeout on response
                        CURLOPT_MAXREDIRS      => 20,       // stop after 10 redirects
                        CURLOPT_BINARYTRANSFER => true,
                        CURLOPT_COOKIEJAR => $usecookie, 
                        CURLOPT_COOKIEFILE => $usecookie 
                );
                
                $curl->addSession($params['page_url'],$opts);
                
                $result = $curl->exec();
                
                
                $curl->clear();
                
                
                if(!is_array($result)){
                    $temp=array();
                    $temp[]=$result;
                    $result=$temp;
                }
                
                if(isset($result[0])) {
                
                    $value=$result[0];
                    
                    
                  
                      
                    if($value){                   
                    $folder=''; // folder for uploaded files
                    if (!(file_exists(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder) && (is_dir(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder)))){
                            mkdir(COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$folder,0755,true);
                    }
                 
                    $filename=uniqid();
                    
                    $path=$folder.DIRECTORY_SEPARATOR.$filename;
                    $path=COMMON_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::FETCH_FOLDER.DIRECTORY_SEPARATOR.$path;
                    $value=str_replace('&','&amp;',$value);
                    file_put_contents($path,$value);                    
                    return $path;                
                    
                    } else {
                      
                        return false;
                        
                    }
                }
                  
                
                        
        }                

 
}