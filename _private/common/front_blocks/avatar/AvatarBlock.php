<?php

/**
 * Class for render form for changing Avatar
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.avatar
 */

class AvatarBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='avatar';
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
                 user()->setFlash('error',t('You need to sign in before continue'));                                                            
                Yii::app()->controller->redirect(bu().'/sign-in');
            }
    }       
 
 
    protected function renderContent()
    {     
               
        
            if(isset($this->block) && ($this->block!=null)){	              
                    $model=new UserAvatarForm;
                    if(isset($_POST['UserAvatarForm']))
                    {
                        $model->attributes=$_POST['UserAvatarForm'];
                        $model->image=CUploadedFile::getInstance($model,'image');                                                
                        if($model->validate())
                        {
                            //Get the User Id to determine the folder
                            $folder=user()->id >= 1000 ? (string)(round(user()->id/1000)*1000) : '1000';
                            $filename=user()->id.'_'.gen_uuid();                           
                               if (!(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$folder) && (AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$folder))){
                                       mkdir(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$folder,0777,true);
                               }
                               if(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename.'.'.strtolower(CFileHelper::getExtension($model->image->name)))) {
                                 $filename.='_'.time();
                             }

                             $filename=$filename.'.'.strtolower(CFileHelper::getExtension($model->image->name));
                             $path=$folder.DIRECTORY_SEPARATOR.$filename;

                             if($model->image->saveAs(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$path)){
                                 
                                 
                                 //Generate thumbs
                                 //
                                 GxcHelpers::generateAvatarThumb($filename, $folder, $filename);
                                 //So we will start to check the info from the user
                                 $current_user=User::model()->findByPk(user()->id);
                                 if($current_user){
                                     if($current_user->avatar!=null && $current_user->avatar!='' ){
                                         //We will delete the old avatar here
                                         $old_avatar_path=$current_user->avatar;
                                         $current_user->avatar=$path;
                                         if(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$old_avatar_path)){
						 @unlink(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$old_avatar_path);
					 }
                                         
                                         //Delete old file Sizes
                                          $sizes=AvatarSize::getSizes();
                                            foreach($sizes as $size){
                                              if(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$old_avatar_path))
                                                  @unlink(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$old_avatar_path);
                                                                                     
                                            }
                                     } else {
                                         //$current_user
                                         $current_user->avatar=$path;
                                     }
                                     $current_user->save();
                                 }
                             } else {
                                 throw new CHttpException('503','Error while uploading!');
                             }                    
                        }
                    }
                   
                                       
            $this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model));
            } else {
                echo '';
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