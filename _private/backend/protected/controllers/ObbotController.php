<?php
/**
 * Backend Osg Bot Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class ObbotController extends BeController{
           
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Fetch Bot'), 'url'=>array('crawl'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Crawl Bot'), 'url'=>array('parse'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
        
         public function actionCrawl(){
            
            $model = new CrawlQueue;
            $this->render('crawl',array(
                    'model'=>$model
		));
        }
        
        public function actionCrawlImage(){            
            $model = new ObjectSale;
            $this->render('crawlimage',array(
                    'model'=>$model
                    ));          
        }
        
        public function actionDoCrawl(){
            Crawl::crawlPagesInQueue();
            user()->setFlash('success','Done!');
	        $this->redirect(array('crawl'));
        }
	
        public function actionResizeImage(){
            $model = new ObjectSale;
            $this->render('resizeimage',array(
                    'model'=>$model
                    ));
        }
        
        public function resizeImages($limit=0){            
            $condition = 'select * from gxc_osg_object_sale where obj_local_image<>"" and obj_resize=0 '.
                                    ($limit!==0 ? ' limit 0,'.$limit : '');
            $list_to_resize = ObjectSale::model()->findAllBySql($condition);
            if (isset($list_to_resize) && count($list_to_resize)>0) {
            	$klog = new KLogger(Yii::getPathOfAlias('common.log').DIRECTORY_SEPARATOR.'resize_image_log', KLogger::INFO);
                foreach ($list_to_resize as $current_object) {
                    $folder_filename = explode('/',$current_object->obj_local_image);
                    $folder = $folder_filename[0];
                    $filename = $folder_filename[1];
				
					if(file_exists(IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_ORIGINAL_FOLDER.DIRECTORY_SEPARATOR.$current_object->obj_local_image)&&getimagesize(IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_ORIGINAL_FOLDER.DIRECTORY_SEPARATOR.$current_object->obj_local_image)){
						$resizer = new ImageResizer(
                        IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_ORIGINAL_FOLDER.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR,
                        $filename,
                        IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_RESIZE_FOLDER.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR,
                        $filename,
                        OsgConstantDefine::IMAGE_RESIZE_WIDTH,//$size['width'],
                        OsgConstantDefine::IMAGE_RESIZE_HEIGHT,//$size['height'],
                        '',//$size['ratio'],
                        90,
                        '#FFFFFF');																													
	                    if(!($resizer->file_error)){
	                    		              	                         		                   
	                    		$resizer->output();
							    $current_object->obj_resize=1;
	                    		$current_object->save();  	                    	
	                    	
	                    }
               
				} else {
					    $current_object->obj_image='';
	                    $current_object->save();  	
						$klog->LogInfo('Error: File not found or not valid at ' . $current_object->obj_local_image);
						
				}
                    
                }
                return new CArrayDataProvider($list_to_resize, array(
                                        'id'=>'success_list',
                                        'keyField'=>'object_id',
                                        'pagination'=>array(
                                            'pageSize'=>50,
                                        )));
            }
            return null;
        }
        
        public function actionDoResizeImage() {
            $model = new ObjectSale;
            
            $list_success_object = $this->resizeImages(OsgConstantDefine::RANDOM_GET);
            //user()->setFlash('success','Done!');
            $this->render('resizeimage',array(
                    'model'=>$model,
                    'list_success_object'=> $list_success_object,                    
                    ));
        }
        
        public function actionDoResizeImageAll(){
            $model = new ObjectSale;
            
            $list_success_object = $this->resizeImages();
            
            //user()->setFlash('success','Done!');
            $this->render('resizeimage',array(
                    'model'=>$model,
                    'list_success_object'=> $list_success_object,                    
                    ));            
        }
    
        public function actionDoCrawlImage() {
            $result = Crawl::crawlImages(OsgConstantDefine::RANDOM_GET);
            $model = new ObjectSale;
            
            $list_success_object = (isset($result['success']) && count($result['success'])>0)
                                    ? new CArrayDataProvider($result['success'], array(
                                        'id'=>'success_list',
                                        'keyField'=>'object_id',
                                        'pagination'=>array(
                                            'pageSize'=>50,
                                        )))
                                    : null;
            $list_failed_object = (isset($result['fail']) && count($result['fail'])>0)
                                    ? new CArrayDataProvider($result['fail'], array(
                                        'id'=>'fail_list',
                                        'keyField'=>'object_id',
                                        'pagination'=>array(
                                            'pageSize'=>50,
                                        )))
                                    : null;
    
            //user()->setFlash('success','Done!');
            $this->render('crawlimage',array(
                    'model'=>$model,
                    'list_success_object'=> $list_success_object,
                    'list_failed_object'=> $list_failed_object,
                    ));            
        }
        
        public function actionDoCrawlImageAll(){                
            $result = Crawl::crawlImages();
            $model = new ObjectSale;
            
            $list_success_object = (isset($result['success']) && count($result['success'])>0)
                                    ? new CArrayDataProvider($result['success'], array(
                                        'id'=>'success_list',
                                        'keyField'=>'object_id',
                                        'pagination'=>array(
                                            'pageSize'=>50,
                                        )))
                                    : null;
            $list_failed_object = (isset($result['fail']) && count($result['fail'])>0)
                                    ? new CArrayDataProvider($result['fail'], array(
                                        'id'=>'fail_list',
                                        'keyField'=>'object_id',
                                        'pagination'=>array(
                                            'pageSize'=>50,
                                        )))
                                    : null;
    
            //user()->setFlash('success','Done!');
            $this->render('crawlimage',array(
                    'model'=>$model,
                    'list_success_object'=> $list_success_object,
                    'list_failed_object'=> $list_failed_object,
                    ));            
        }
        
	    public function actionParse(){
            
            $model = new ParseQueue;
            $this->render('parse',array(
                    'model'=>$model
		));
        }
	
	public function actionDoParse(){
            
            Parse::parsePagesInQueue();
            user()->setFlash('success','Done!');	    
	    $this->redirect(array('parse'));
            
        }
        
}