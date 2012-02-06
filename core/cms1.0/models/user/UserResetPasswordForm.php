<?php

/**
 * This is the model class for Reset Password
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserResetPasswordForm extends CFormModel
{
    public $password;        

	
	public function rules()
	{
            return array(
               array('password','required'),
               array('password','length','min'=>'3'),                                     
             );
	}

        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>t('New password'),                       
		);
	}

}