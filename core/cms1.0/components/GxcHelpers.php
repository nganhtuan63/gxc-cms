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
       
    
    public static function getAvailableContentType($render_view=false){                    
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
    
}
