<?php

/**
 * This is the model class for Share Lessons.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.models
 *
 */
class ShareLessonForm extends CFormModel
{
            
        public $name;        
        public $content;
		public $description;
        public $format;
        public $image;
        public $link_youtube;
        public $source;
        public $finish;		
		public $cat;
        

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
            	array('format,cat','numerical'),   
                array('name', 'required','message'=>'Bạn cần nhập tiêu đề cho bài học', ),
                array('content', 'required','message'=>'Nội dung còn trống', ),                
                array('name,source', 'length', 'max'=>255,'message'=>'Không được nhiều hơn 255 ký tự'),
                array('image','url','allowEmpty'=>true,'message'=>'Không đúng định dạng địa chỉ web'),
                array('link_youtube','checkYoutubeLink'),
                array('finish','in','range'=>array(0,1))
                                                
             );
	}

        
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(			
                'name'=>t('Tiêu đề'),                
                'content'=>t('Nội dung'),
                'image'=>t('Ảnh đại diện'),
                'link_youtube'=>t('Youtube video'),
                'format'=>t('Định dạng'),
                'cat'=>t('Danh mục'),
				                         
		);
	}
	
	public function checkYoutubeLink($attribute,$params)
	{
		
		 if($this->format==HmnConstantDefine::LESSON_YOUTUBE){
		 	if(trim($this->link_youtube)!=''){
			 	if(!get_youtube_id(trim($this->link_youtube))){
			 		 $this->addError($attribute,t('Đường dẫn Youtube video không đúng'));
	                 return false;
			 	}
			 } else {
			 		$this->addError($attribute,t('Bạn cần nhập đường dẫn cho Youtube video'));
	                 return false;
			 }
		 }
	
		
			
	}
              

}