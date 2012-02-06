<?php

/**
 * This is the model class for System Settings Form
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.settings
 *
 */
class SettingSystemForm extends CFormModel
{
	public $support_email;
        public $page_size;
        public $language_number;
        
        public $page_slug;
        public $term_slug;
        public $content_slug;
	

	/**
	 * Declares the validation rules.
	 * 
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('support_email, page_size, language_number,page_slug,term_slug,content_slug', 'required'),
                        array('support_email', 'email'),
                        array('language_number, page_size','numerical','integerOnly'=>true,'min'=>1),
                        array('language_number','checkAvailableLanguage')			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'support_email'=>t('Support email'),
                        'page_size'=>t('Items per page'),
                        'language_number'=>t('Number of Language Available'),
                    
                        'page_slug'=>t('Page slug name'),
                        'term_slug'=>t('Term page slug name'),
                        'content_slug'=>t('Content details slug page name')
		);
	}
        
        /**
	 * Check available Languages of the Current System
	 * 
	 */
	public function checkAvailableLanguage($attribute,$params)
	{
		if(!$this->hasErrors())
		{                    
                        //First we need to check all the Active Languages of the CMS
                        $languages=Language::loadItems();
                        if($this->language_number>count($languages)){
                            $this->addError('language_number',t('Site currently supports only ').count($languages).' '.t('Languages'));
			    return false;
                        }
			
		}
	}

	
       
}
