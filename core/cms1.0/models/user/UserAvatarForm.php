<?php

/**
 * This is the model class for Upload Avatar
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.models.user
 *
 */
class UserAvatarForm extends CFormModel
{
		public $image;
		        

        public function rules()
        {
            return array(
                array('image', 'file', 'types'=>'jpg, gif, png','maxSize'=>1024 * 1024 * 2,'minSize'=>1024),
            
            );
        }

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                'image'=>t('Avatar'),
                		
		);
	}
	       
}
