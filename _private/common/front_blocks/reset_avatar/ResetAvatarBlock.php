<?php

/**
 * Class for render form for reset Avatar
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.reset_avatar
 */

class ResetAvatarBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='reset_avatar';
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
                    
                    if(isset($_POST['ResetAvatar']))
                    {                        
                             //So we will start to check the info from the user
                             $current_user=User::model()->findByPk(user()->id);
                             if($current_user){
                                 if($current_user->avatar!=null && $current_user->avatar!='' ){
                                     //We will delete the old avatar here
                                     $old_avatar_path=$current_user->avatar;                                     
                                     if(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$old_avatar_path)){
										 @unlink(AVATAR_FOLDER.DIRECTORY_SEPARATOR.'root'.DIRECTORY_SEPARATOR.$old_avatar_path);
									 }                                     
                                     //Delete old file Sizes
                                      $sizes=AvatarSize::getSizes();
                                        foreach($sizes as $size){
                                          if(file_exists(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$old_avatar_path))
                                              @unlink(AVATAR_FOLDER.DIRECTORY_SEPARATOR.$size['id'].DIRECTORY_SEPARATOR.$old_avatar_path);
                                                                                 
                                        }
									$current_user->avatar='';
									if($current_user->save()){
										echo "1";	
										Yii::app()->end();
									}
									 
                                 } 
                             }
	                         else {
	                             throw new CHttpException('403','Wrong Link!');
	                         }                    
                    }
					Yii::app()->controller->redirect(bu().'/profile');

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