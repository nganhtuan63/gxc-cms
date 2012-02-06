<?php

/**
 * This is the model class for Upload Image
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.models
 *
 */
class UploadImageForm extends CFormModel
{
		public $image;
		public $image_url;        

        public function rules()
        {
            return array(
                array('image', 'file', 'maxSize'=>1024 * 1024 * 3,'minSize'=>250,'allowEmpty'=>true),
                array('image_url', 'url','allowEmpty'=>true),
            );
        }

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                'image'=>t('File'),
                'image_url'=>t('Đường dẫn'),				
		);
	}
	       
}
