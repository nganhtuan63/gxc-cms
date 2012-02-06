<?php

/**
 * This is the model class for General Settings Form
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.settings
 *
 */
class SettingGeneralForm extends CFormModel
{
	public $site_name;
        public $site_title;
        public $site_description;
        
        public $homepage;
        
	

	/**
	 * Declares the validation rules.
	 * 
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('site_name, homepage', 'required'),                      		
                        array('site_title, site_description', 'safe'), 
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'site_name'=>t('Site name'),
                        'site_title'=>t('Site title'),
                        'site_description'=>t('Site description'),
                        'homepage'=>t('Page name used as Homepage'),
		);
	}
                
	
       
}
