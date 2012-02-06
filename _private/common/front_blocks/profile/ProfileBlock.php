<?php

/**
 * Class for render User Profile
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.profile
 */

class ProfileBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='profile';
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
                    $model=new UserProfileForm;
                    
                    //Set basic info for Current user
                    
                    //Get the user by current Id
                    $user_info=User::model()->findByPk(user()->id);
                    if($user_info){
                        $model->display_name=$user_info->display_name;
                        $model->email=$user_info->email;
                        $model->bio=$user_info->bio;
                        $model->gender=$user_info->gender;
                        $model->location=$user_info->location;
                        $model->birthday_day=$user_info->birthday_day;
                        $model->birthday_month=$user_info->birthday_month;
                        $model->birthday_year=$user_info->birthday_year;
                    } else {
                        throw new CHttpException('503','User is not valid');
                    }
                    
                    
                    // if it is ajax validation request
                    if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
                    {
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                    }

                    // collect user input data
                    if(isset($_POST['UserProfileForm']))
                    {

                            $model->attributes=$_POST['UserProfileForm'];
                            // validate user input and redirect to the previous page if valid                            
                            if($model->validate()){
                                $user_info->scenario='update';
                                $user_info->display_name=$model->display_name;
                                $user_info->gender=$model->gender;
                                $user_info->location=$model->location;
                                $user_info->bio=$model->bio;
                                $user_info->birthday_day=$model->birthday_day;
                                $user_info->birthday_month=$model->birthday_month;
                                $user_info->birthday_year=$model->birthday_year;
                                $user_info->save();
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