<?php

/**
 * Class for render Sign up Box
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.signup
 */

class SignupBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='signup';
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
                $model=new UserRegisterForm;
                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']==='userregister-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }

                // collect user input data
                if(isset($_POST['UserRegisterForm']))
                {
                        $model->attributes=$_POST['UserRegisterForm'];

                        // validate user input password
                        if($model->validate()){
                                $new_user = new User;
                                $new_user->scenario='create';
                                //$new_user->username=$model->username;                                                               
                                $new_user->username=$new_user->email=$model->email;                                                                                               
                                $new_user->display_name=$model->display_name;
                                $old_password=$new_user->password=$model->password;           
                                
                                //Create hash activation key
                                $new_user->user_activation_key=md5(time().$new_user->username.ConstantDefine::USER_SALT);
                                if($new_user->save()){                                         
                                        	//We will send mail for the user
                                        	
                                        	$ses = new SimpleEmailService(OsgConstantDefine::AMAZON_SES_ACCESS_KEY,OsgConstantDefine::AMAZON_SES_SECRET_KEY);
											$ses->enableVerifyHost(false);			
											$m = new SimpleEmailServiceMessage();
											$m->addTo($new_user->email);
											$m->setFrom(OsgConstantDefine::AMAZON_SES_EMAIL);
											$m->setSubject('['.ConstantDefine::SITE_NAME.'] Confirm your email at '.ConstantDefine::SITE_NAME_URL);
											
											$m_content='Hi '.$new_user->display_name.'<br /><br />';
											$m_content.='Welcome to '.ConstantDefine::SITE_NAME.'! Please take a second to confirm '.$new_user->email.' as your email address by clicking this link: <br /><br />';
											$link_content=FRONT_SITE_URL.'/user-activation/?key='.$new_user->user_activation_key.'&user_id='.$new_user->user_id;
											$m_content.='<a href="'.$link_content.'">'.$link_content.'</a><br /><br />';
											$m_content.='Thank you for being with us!<br /><br />';
											$m_content.=ConstantDefine::SITE_NAME.' Team';
											$m->setMessageFromString($m_content,$m_content);
											$ses->sendEmail($m);
											                                                                            
                                        	//Redirect to the Dashboard Page                                                                                                                  
                                            $login_form=new UserLoginForm();
                                            $login_form->username=$new_user->username;
                                            $login_form->password=$old_password;
                                            if($login_form->login()){
                                                Yii::app()->controller->redirect(bu().'/dashboard');
                                            } else {
                                                throw new CHttpException(503,t('Error while setting up your Account. Please try again later'));
                                            }
                                                                      
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