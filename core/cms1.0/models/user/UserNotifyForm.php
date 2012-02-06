<?php

/**
 * This is the model class for Update Notify Form.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserNotifyForm extends CFormModel
{
        public $email_site_news;
        public $email_search_alert;
       

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                 array('email_site_news','in','range'=>array('0','1')), 
                 array('email_search_alert','in','range'=>array('0','1')),        
             );
	}
     
        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email_site_news' => t('Email site news'),
            'email_search_alert' => t('Email search alert')
		);
	}

}