<?php

/**
 * This is the model class for Register Form.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserRegisterForm extends CFormModel
{
	public $username;
	public $email;
	public $password;
        
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username, email and password are required
			array('username, email, password', 'required'),
			// email need to be email style
                        array('email', 'email' , 'message'=>t('Email is not valid')),
			array('email', 'unique',
                        'attributeName'=>'email',
                        'className'=>'cms.models.user.User',
                        'message'=>t('This email has been registered.')),
			
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			
                        'username'=>t('Username'),
                        'email'=>t('Email'),
                        'password'=>t('Password')
		);
	}

	
        /**
         * Function to Register user information
         * @return type 
         */
        public function doSignUp()
	{
		if(!$this->hasErrors())
		{
			$newUser = new User;
			
			$newUser->password=$this->password;
                        
			if(!$newUser->save()){
                                $this->addError('email',t('Something is wrong with the Registration Process. Please try again later!'));
                                return false;
			} else {                          				
                            //We can start to add Profile record here                            				
                             
                            //We can start to add User Activity here
                            
                            //We can check to send Email or not   

                            //Create new UserLoginForm
                            $login_form=new UserLoginForm();
                            $login_form->username=$newUser->username;
                            $login_form->password=$this->password;
                            return $login_form->login();
			}
				
		}
	}

        
	
}
