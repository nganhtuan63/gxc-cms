<?php

/**
 * This is the model class for Basic Settings Form.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserSettingsForm extends CFormModel
{
        public $display_name;
        public $email;
        
        

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                array('display_name, email', 'required'),     
                array('display_name', 'length', 'max'=>255),
                array('email', 'length', 'max'=>128),
                array('email', 'email' , 'message'=>t('Email is not valid')),
                array('email', 'checkEmailValid')
             );
	}

        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'display_name'=>t('Display name'),
                        'email'=>t('Email')                        
		);
	}
        
        /**
	 * Check if the user updated his email ok or not
	 * This is the 'checkEmailValid' validator as declared in rules().
	 */
	public function checkEmailValid($attribute,$params)
	{
		if(!$this->hasErrors())
		{
                        $user_with_email=User::model()->find('LOWER(email) = :email',array(':email'=>  strtolower($this->email)));
                        if($user_with_email){
                            if($user_with_email->user_id!=user()->id){
                                $this->addError('email',t('Email already in use.'));
                                return false;
                            }
                            
                        } 
			
		}
	}

}