<?php

/**
 * This is the Widget for create new Resource.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets.resource
 *
 */
class ResourceCreateWidget extends CWidget
{
    
    public $visible=true; 
 
    public function init()
    {
        
    }
 
    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }
 
    protected function renderContent()
    { 
                                      
        $model=new ResourceUploadForm;
 		$is_new=true;     
		$process=true;   
		$types_array=ConstantDefine::fileTypes();
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='resource-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['ResourceUploadForm']))
        {                
				$model->attributes=$_POST['ResourceUploadForm'];												
            	$model->upload=CUploadedFile::getInstance($model,'upload');		
				$allow_types=array();		
				$max_size=ConstantDefine::UPLOAD_MAX_SIZE;
				$min_size=ConstantDefine::UPLOAD_MIN_SIZE;
                
				$resource = new Resource;        
               
			   //Is it has content type and resource type params?
			   
			    
			   
                $content_type_param=isset($_GET['content_type']) ? trim($_GET['content_type']) : '';
				$resource_type_param=isset($_GET['type']) ? trim($_GET['type']) : '';
				
								
																
				if(($content_type_param!='')&&($resource_type_param!='')){
					
					  
					//Get content type	
					$types=GxcHelpers::getAvailableContentType();
					if(isset($types[$content_type_param])){						
						Yii::import('common.content_type.'.$content_type_param.'.'.$types[$content_type_param]['class']);
						//Init content type class
						$typeClassObj = new $types[$content_type_param]['class'];
						//Get Resource lists
						$resources=$typeClassObj->Resources();						
						if(isset($resources[$resource_type_param])){
							$allow_types=$resources[$resource_type_param]['allow'];
							$max_size=$resources[$resource_type_param]['maxSize'];
							$min_size=$resources[$resource_type_param]['minSize'];
						}  
					}					

				}
				
				
							 
               
			   
			    $resource->resource_type=$model->type;                                               
                if($model->link!=''){
                    $temp_ext=strtolower(substr($model->link, -4));
                    if($temp_ext[0]!='.'){
                       $model->addError('link', t('File not valid'));
                       $process=false;
                    } else {
                        //Need to check if Image File Type
                        $ext=substr($temp_ext,-3);
                        if($model->type=='image'){ //It is Image                        
                        	//Get Images array                        
                            if(!in_array(strtolower($ext),$types_array['image'] )){
                                $model->addError('link', t('Not valid Image'));
                                $process=false;
                            } else {
                                //Start to Save to the Remote File
                                                                
                                if(!GxcHelpers::getRemoteFile($resource,$model,$process,$message,$model->link,$ext,true,$max_size,$min_size,$allow_types)){
                                    $model->addError('link', t('Error while saving Image'));
                                    $process=false;
                                }
                            }
                            
                        } else {
                            $explode_name=explode('/',$model->link);
                            $resource->resource_name=$explode_name[count($explode_name)-1];
                            $resource->resource_path=trim($model->link);         
														
							//Implement to check types of the external resource here
							$resource->resource_type='file';
							$resource->where='external';
										                   
                            $process=true;
                        }                       
                    }                    
                } else {
                	
                    if($model->upload!=null){
                    		
                    	$storages=GxcHelpers::getStorages(true);
						//We won't allow external storage for Upload File
						//Unless we use Amazon S3							
						if($model->where=='external'){
							$model->where='local';
						}																		
						//First we need to check if the file size is allowed?
						$upload_handle=new $storages[$model->where]($max_size,$min_size,$allow_types);											
						if(!$upload_handle->uploadFile($resource,$model,$process,$message)){
							$model->addError('upload', $message);
							$process=false;
						}
											                       
                     } else {
                        $model->addError('upload', 'Choose File before Upload');
						$process=false;
                     }                     
                }
                if($process){
                    if($model->name!=''){
                        $resource->resource_name=trim($model->name);						
                    }
					$resource->where=$model->where;					
					$resource->resource_type=$model->type;
                    $resource->resource_body=trim($model->body);  										                  
                    if($resource->save()){
                    	if((isset($_GET['parent_call']))&&(isset($_GET['type']))){
                    		$this->render('cmswidgets.views.resource.resource_upload_iframe_return',array('resource'=>$resource));
							Yii::app()->end();
                    	} else {
                    		user()->setFlash('success',t('Create new Resource Successfully!'));
							Yii::app()->controller->redirect(array('create'));
                    		}                                 
                    	}
                    	
					
                }
				
				
        }

        $this->render('cmswidgets.views.resource.resource_form_widget',array('model'=>$model,'is_new'=>$is_new,'types_array'=>$types_array));
    }   
}
