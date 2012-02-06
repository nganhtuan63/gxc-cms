<?php

/**
 * Class for render Recover Password Block
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.recover_password
 */

class RecoverPasswordBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='recover_password';
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
		
			
				     	$model=new UserRecoverPassForm;
						// if it is ajax validation request
						if(isset($_POST['ajax']) && $_POST['ajax']==='recoverpassword-form')
						{
							echo CActiveForm::validate($model);
							Yii::app()->end();
						}
				                   
						// collect user input data
						if(isset($_POST['UserRecoverPassForm']))
						{
				                       
							$model->attributes=$_POST['UserRecoverPassForm'];
							// validate user input and redirect to the previous page if valid
							 if($model->validate())
							 {
							 		//Find the user with the email
							 		$user=User::model()->find('email=:email',array(':email'=>$model->email));
									if($user){
											//Create a new password recover key
											$key=md5(ConstantDefine::USER_RECOVER_PASS_SALT.time().$user->username.$user->email);
											$user->email_recover_key=$key;
											if($user->save()){
												
													$ses = new SimpleEmailService(OsgConstantDefine::AMAZON_SES_ACCESS_KEY,OsgConstantDefine::AMAZON_SES_SECRET_KEY);
													$ses->enableVerifyHost(false);			
													$m = new SimpleEmailServiceMessage();
													$m->addTo($user->email);
													$m->setFrom(OsgConstantDefine::AMAZON_SES_EMAIL);
													$m->setSubject('['.ConstantDefine::SITE_NAME.'] Password reset instructions');
													
													$m_content='Hi '.$user->display_name.'<br /><br />';
													$m_content.='A request to reset your '.ConstantDefine::SITE_NAME.' password has been made. If you did not make this request, simply ignore this email. If you did make this request, just click the link below:<br /><br />';
													$link_content=FRONT_SITE_URL.'/reset-password/?key='.$user->email_recover_key.'&user_id='.$user->user_id;
													$m_content.='<a href="'.$link_content.'">'.$link_content.'</a><br /><br />';
													$m_content.='If the URL above does not work, try copying and pasting it into your browser.<br /><br />';
													$m_content.='If you continue to have problems, please feel free to contact us: <a href="mailto:'.ConstantDefine::SUPPORT_EMAIL.'">'.ConstantDefine::SUPPORT_EMAIL.'</a><br /><br />';
													$m_content.='Thank you for being with us!<br /><br />';
													$m_content.=ConstantDefine::SITE_NAME.' Team';
													$m->setMessageFromString($m_content,$m_content);
													$ses->sendEmail($m);											
												 user()->setFlash('success','Instructions to reset your password have been sent to you. Please check your email.');
												 Yii::app()->controller->redirect(bu().'/sign-in');
											}
									} else {
										user()->setFlash('error','Email is not existed');
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