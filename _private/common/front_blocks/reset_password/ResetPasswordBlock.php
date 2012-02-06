<?php

/**
 * Class for render Reset Password Block
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.reset_password
 */

class ResetPasswordBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='reset_password';
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
				if((isset($_GET['key']))&&($_GET['user_id'])){
					
								$key=$_GET['key'];
								$user_id=(int)$_GET['user_id'];
								
								//Find the user 
								$user=User::model()->findByPk($user_id);
								if(($user)&&($user->email_recover_key!='')){
											$model=new UserResetPasswordForm;
											// if it is ajax validation request
											if(isset($_POST['ajax']) && $_POST['ajax']==='resetpassword-form')
											{
												echo CActiveForm::validate($model);
												Yii::app()->end();
											}						                   
											// collect user input data
											if(isset($_POST['UserResetPasswordForm']))
											{									                       
												 $model->attributes=$_POST['UserResetPasswordForm'];
												 // validate user input and redirect to the previous page if valid
												 if($model->validate())
												 {
												 		$user->email_recover_key='';
														$user->salt=ConstantDefine::USER_SALT;
														$user->password=User::model()->hashPassword($model->password,ConstantDefine::USER_SALT);
														if($user->save()){																																					
															 user()->setFlash('success','Your password has been reset.');
															 Yii::app()->controller->redirect(bu().'/sign-in');
														}
												 }
											}              
						        			$this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model));
								} else {
									Yii::app()->controller->redirect(bu().'/sign-in');
								}							
				}			
				else {
						Yii::app()->controller->redirect(bu().'/sign-in');
				}
						     
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