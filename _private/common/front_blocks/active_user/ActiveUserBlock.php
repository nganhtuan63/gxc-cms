<?php

/**
 * Class for render form for Active User
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.active_user
 */

class ActiveUserBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='active_user';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {       
            $this->renderContent();
    }       
 
 
    protected function renderContent()
    {     
                       
           if(isset($this->block) && ($this->block!=null)){	                                  
                    $user_id=(int)$_GET['user_id'];
	                $key=$_GET['key'];                
	                //Find the User
	                $user=User::model()->findByPk($user_id);
	                if($user){
	                    if($user->confirmed==0){                                                
	                        //Ok We will check the key here
	                        if($user->user_activation_key==$key){
	                            $user->confirmed=1;
	                            if($user->save()){                                
	                               user()->setFlash('success','You have confirmed your account! Please sign in to coninue');
	                               Yii::app()->controller->redirect(bu().'/sign-in');
	                            }
	                        }                                                 
	                    }
	                }
	                throw new CHttpException('503','Wrong Link');
           }	
		   Yii::app()->end();
       
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