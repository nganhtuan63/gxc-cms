<?php

/**
 * Helpers Class for whole CMS
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.components
 */
class GxcHelpers {
    
    public static function loadDetailModel($model_name,$id){    
            $model=call_user_func(array($model_name, 'model'))->findByPk((int)$id);
            if($model===null)
                    throw new CHttpException(404,t('The requested page does not exist.'));
            return $model;	
    }
    
    public static function deleteModel($model_name,$id){
            if(Yii::app()->request->isPostRequest){
                    // we only allow deletion via POST request
                   GxcHelpers::loadDetailModel($model_name, $id)->delete();
                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else
                    throw new CHttpException(400,t('Invalid request. Please do not repeat this request again.'));
    }
    
    public static function getAvailableLayouts($render_view=false){
    	
			//Need to implement Cache HERE                    
            $layouts = array();            
            $folders = get_subfolders_name(Yii::getPathOfAlias('common.front_layouts')) ;    
            foreach($folders as $folder){
                $temp=parse_ini_file(Yii::getPathOfAlias('common.front_layouts.'.$folder.'').DIRECTORY_SEPARATOR.'info.ini');
                 if($render_view)
                    $layouts[$temp['id']]=$temp['name'];
                 else 
                    $layouts[$temp['id']]=$temp;
            }                               
            return $layouts;            
    }
    
    public static function getAvailableBlocks($render_view=false){
    	
			//Need to implement Cache HERE                    
            $blocks = array();            
            $folders = get_subfolders_name(Yii::getPathOfAlias('common.front_blocks')) ;    
            foreach($folders as $folder){
                $temp=parse_ini_file(Yii::getPathOfAlias('common.front_blocks.'.$folder.'').DIRECTORY_SEPARATOR.'info.ini');
                 if($render_view)
                    $blocks[$temp['id']]=$temp['name'];
                 else 
                    $blocks[$temp['id']]=$temp;
            }        
            
            return $blocks;
    }
	
	public static function getStorages($get_class=false){		
			    
		$temp=parse_ini_file(Yii::getPathOfAlias('common.storages.'.'').DIRECTORY_SEPARATOR.'info.ini');								
		$types=array();		
		foreach ($temp['storages'] as $key=>$value){
			if(!$get_class)
				$types[$key]=trim(ucfirst($key));
			else {
				$types[$key]=trim($value);
			}		
		}		
		return $types;
	}
       
    
    public static function getAvailableContentType($render_view=false){
    	
			//Need to implement Cache HERE                    
            $types = array();            
            $folders = get_subfolders_name(Yii::getPathOfAlias('common.content_type')) ;   						 
            foreach($folders as $folder){
                $temp=parse_ini_file(Yii::getPathOfAlias('common.content_type.'.$folder.'').DIRECTORY_SEPARATOR.'info.ini');
                 if($render_view)
                    $types[$temp['id']]=$temp['name'];
                 else 
                    $types[$temp['id']]=$temp;
            }        
            			
            return $types;
    }
	
	public static function getRemoteFile(&$resource,$model,&$process,&$message,$path,$ext,$changeresname=true){
		
		
		if(GxcHelpers::remoteFileExists($path)){
			$storages=GxcHelpers::getStorages(true);	
			$upload_handle=new $storages[$model->where](ConstantDefine::UPLOAD_MAX_SIZE,ConstantDefine::UPLOAD_MIN_SIZE);					
			if(!$upload_handle->getRemoteFile($resource,$model,$process,$message,$path,$ext,true)){
				$model->addError('upload', $message);
			} else {
				$process=true;
				return true;
			} 
		} else {
			$process=false;
			$message=t('Remote file not exist');
			return false;
		}

	}


	public static function remoteFileExists($url) {
		$curl = curl_init($url);
	    
		//don't fetch the actual page, you only want to check the connection is ok
		curl_setopt($curl, CURLOPT_NOBODY, true);
	    
		//do request
		$result = curl_exec($curl);
	    
		$ret = false;
	    
		//if request did not fail
		if ($result !== false) {
		    //if request was ok, check response code
		    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
	    
		    if ($statusCode == 200) {
			$ret = true;   
		    }
		}
	    
		curl_close($curl);
	    
		return $ret;
	}
    
    public static function generateAvatarThumb($upload_name,$folder,$filename){		
            //Start to check if the File type is Image type, so we Generate Everythumb size for it
            if(in_array(strtolower(CFileHelper::getExtension($upload_name)),array('gif','jpg','png'))){
                
                //Start to create Thumbs for it                
                $sizes=AvatarSize::getSizes();
                foreach($sizes as $size){
                        if (!(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$folder) && (AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$folder))){
                                        mkdir(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$folder,0777,true);
                        }
                        
                        $thumbs = new ImageResizer(
                                AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR,
                                $filename,
                                AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR,
                                $filename,
                                $size['width'],
                                $size['height'],
                                $size['ratio'],
                                90,
                                '#FFFFFF');
                                $thumbs->output();

                }
            }
            
    }
    
    public static function getUserAvatar($size,$avatar,$default){
        if(($avatar!=null)&&($avatar!='')){
            return AVATAR_URL.'/'.$size.'/'.$avatar;
        } else {
            return $default;
        }
    }
	
	
	public static function renderTextBoxResourcePath($data){
		return '<input type="text" class="pathResource" value="'.$data->getFullPath().'" />';
	}
	
	public static function renderLinkPreviewResource($data){
		switch($data->resource_type){
			case 'image':
				return '<a href="'.$data->getFullPath().'" rel="prettyPhoto" title="'.$data->resource_name.'">'.t('View').'</a>';
				break;
			case 'video':
				return '<a href="'.app()->controller->backend_asset.'/js/jwplayer/player.swf?width=470&amp;height=320&flashvars=file='.$data->getFullPath().'" title="'.$data->resource_name.'" rel="prettyPhoto">'.t('View').'</a>';
				break;
			default:
				return '<a href="'.$data->getFullPath().'">'.t('View').'</a>';
				break;
				
		}
		
	}
    
}
