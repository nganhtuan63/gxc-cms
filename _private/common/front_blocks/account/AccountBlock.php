<?php

/**
 * Class for render Account Page
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.account
 */

class AccountBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='account';
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
                 user()->setFlash('error',t('Bạn cần đăng nhập để sử dụng chức năng này!'));                                                         
                Yii::app()->controller->redirect(bu().'/sign-in');
            }
    }       
 
 
    protected function renderContent()
    {     
               
        
            if(isset($this->block) && ($this->block!=null)){	              
                    $model=new UserChangePassForm;
					$model_notify=new UserNotifyForm;
                                          
                    // if it is ajax validation request
                    if(isset($_POST['ajax']) && $_POST['ajax']==='changepass-form')
                    {
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                    }
					
					// if it is ajax validation request
                    if(isset($_POST['ajax']) && $_POST['ajax']==='notify-form')
                    {
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                    }

  					$u=User::model()->findbyPk(user()->id);
                    if($u!==null){
							//Set Email Notify from User
							$model_notify->email_site_news=$u->email_site_news;				                           
							$model_notify->email_search_alert=$u->email_search_alert;
											
						 	// collect user input data
				            if(isset($_POST['UserChangePassForm']))
				            {
				                    $model->attributes=$_POST['UserChangePassForm'];
				                    
				                    // validate user input password
				                    if($model->validate()){				                       
		                                    $u->password=$u->hashPassword($model->new_password_1,  ConstantDefine::USER_SALT);
		                                    $u->salt=ConstantDefine::USER_SALT;
		                                    if($u->save()){               
		                                        user()->setFlash('success',t('Change Password Successfully!'));                                        
		                                    }				                            
				                            $model=new UserChangePassForm;				
				                    }
				            }
							
							 // collect user input data
				            if(isset($_POST['UserNotifyForm']))
				            {
				                    $model_notify->attributes=$_POST['UserNotifyForm'];				                    
				                    // validate user input password
				                    if($model_notify->validate()){
				                            $u->email_site_news=$model_notify->email_site_news;				                           
											$u->email_search_alert=$model_notify->email_search_alert;
		                                    if($u->save()){               
		                                        user()->setFlash('success',t('Update Notification Successfully!'));                                        
		                                    }				                            				                            			
				                    }
				            }
					} else {
						throw new CHttpException('403','User is not existed');
					}   
	            $this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model,'model_notify'=>$model_notify));
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