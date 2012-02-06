<?php

/**
 * This is the model class for Changing User Profile.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserProfileForm extends CFormModel
{
        public $display_name;
        public $email;                
        public $bio;
        public $gender;
        public $location;
        public $birthday_month;
        public $birthday_day;
        public $birthday_year;

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
                array('email', 'checkEmailValid'),
                array('bio', 'length', 'max'=>1500),
                array('birthday_month', 'in', 'range'=>array('january','febuary','march','april','may','june','july','august','september','october','november','december')),
                array('birthday_day', 'numerical'),
                array('birthday_year', 'numerical'),    
                array('gender','length','max'=>'10'),
                array('location','length','max'=>'100')
             );
	}

        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'display_name'=>t('Full name'),
                        'email'=>t('Email'),   
                        'gender'=>t('I Am'),
                        'bio'=>t('Describe yourself'),
                        'birthday_month'=>t('Month'),
                        'birthday_day'=>t('Day'),
                        'birthday_year'=>t('Year'),
                        'location'=>t('Where you live'),
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
                                $this->addError('email',t('Email has been used.'));
                                return false;
                            }
                            
                        } 
			
		}
	}

}