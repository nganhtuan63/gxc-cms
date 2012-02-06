<?php

/**
 * This is the model class for Register User.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.models
 *
 */
class UserRegisterForm extends CFormModel
{
            
        public $display_name;
        public $password;
        public $email;
        

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                array('display_name, email, password', 'required'),                
                array('display_name', 'length', 'max'=>255),
                array('password','length','min'=>3),
                array('email', 'length', 'max'=>128),
                array('email', 'email' , 'message'=>t('Email is not valid')),
                array('email', 'unique',
                        'attributeName'=>'email',
                        'className'=>'cms.models.user.User',
                        'message'=>t('This email has been registerd.')),
                
             );
	}

        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(			
                        'display_name'=>t('Full name'),
                        'password'=>t('Password'),
                        'email'=>t('Email')                        
		);
	}
              

}