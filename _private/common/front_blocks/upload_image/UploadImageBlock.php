<?php

/**
 * Class for render form for Upload Image
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.upload_image
 */

class UploadImageBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='upload_image';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {       
            if(!user()->isGuest){ 
                    $this->renderContent();
              } else {
                 user()->setFlash('error',t('Bạn cần đăng nhập để sử dụng tính năng này!'));                                                            
                 Yii::app()->controller->redirect(bu().'/sign-in');
            }
    }       
 
 
    protected function renderContent()
    {     
                       
            if(isset($this->block) && ($this->block!=null)){
            	 	$model=new UploadImageForm;
					$img = false;
                    if(isset($_POST['UploadImageForm']))
                    {
                    	$model->attributes=$_POST['UploadImageForm'];
                        $model->image=CUploadedFile::getInstance($model,'image');                                                
                        if($model->validate())
                        {
                        	if(!$model->image){
                        		if(!$model->image_url){
                        			$model->addError('image','Bạn cần chọn File để upload');
                        		} else {
                        			$this->sendToImgUr($img,$model,$model->image_url,'url');
                        		}
                        	} else {
                        										
                        		$filename = $model->image->tempName;
							    $handle = fopen($filename, "r");
							    $data = fread($handle, filesize($filename));
							
								$this->sendToImgUr($img,$model,$data);							  
                        	}
						}
						
					}	     
					                             
                    $this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model,'img'=>$img));
			}
			else {
		            echo '';
		    }

           
       
    }

	public function sendToImgUr(&$img,&$model,$data,$type='data'){
		
		 	$timeout = 30;
		    $curl    = curl_init();
			// $data is file data
			if($type=='data'){
		    	$pvars   = array('image' => base64_encode($data), 'key' => HmnConstantDefine::IMGUR_API_KEY);
				
			} else{
				$pvars   = array('image' => $data, 'key' => HmnConstantDefine::IMGUR_API_KEY);				
			
			}		   		
		    
		    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.json');
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
		
		    $xml = curl_exec($curl);
		
		    curl_close ($curl);
			
			if($xml){
								
				$xml=json_decode($xml);
								
				if(isset($xml->error)){
										
					$model->addError('image','Có lỗi trong quá trình upload');
				} else {
					$model = new UploadImageForm;
					$img=$xml->upload->links->original;										
				}
				
			} else {
				$model->addError('image','Có lỗi trong quá trình upload');
			}
		
	}
    
    public function validate(){	
		return true ;
    }
    
    public function params()
    {
         return array();
    }
    
    public function beforeBlockSave(){
	return true;
    }
    
    public function afterBlockSave(){
	return true;
    }
}

?>