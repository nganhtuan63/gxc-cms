<?php

/**
 * Class for render Share Lesson Block
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.profile
 */

class ShareLessonBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='share_lesson';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {       
            if(!user()->isGuest){ 
                    $this->renderContent();
              } else {
                 user()->setFlash('error',t('Bạn cần đăng nhập để sử dụng chức năng này!'));                                                            
                Yii::app()->controller->redirect(bu().'/sign-in');
            }
    }       
 
 
    protected function renderContent()
    {     
                         
            if(isset($this->block) && ($this->block!=null)){
         
                    $model=new ShareLessonForm;
					$model->finish=HmnConstantDefine::LESSON_FINISH;
                    	
                    // if it is ajax validation request
                    if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
                    {
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                    }

                    // collect user input data
                    if(isset($_POST['ShareLessonForm']))
                    {
                    			
                    		$obj_lesson=array();
							
                    		$model->attributes=$_POST['ShareLessonForm'];
                    		
														                            							
                            // validate user input and redirect to the previous page if valid                            
                            if($model->validate()){
                            	
								$filter=new InputFilter(array(),array(),0,0,1);
								$obj_lesson['name']=$model->name=$filter->process($model->name);
								$obj_lesson['source']=$model->source=$filter->process($model->source);							
								
							    Yii::import('common.extensions.markdown');
								$parser = new Markdown();
								$model->content=$filter->process($model->content);
								$obj_lesson['raw']=$model->content;
								$obj_lesson['content']=$model->content=$parser->transform($model->content);
								
								preg_match("/<p>(.*)<\/p>/",$obj_lesson['content'],$matches);
								$obj_lesson['description'] = isset($matches[1]) ? strip_tags($matches[1]) : '';
								$obj_lesson['format']=$model->format;
								$obj_lesson['finish']=$model->finish;
								$obj_lesson['cat']=(int)$model->cat;
								
								$obj_lesson['obj_data']='';
								if($model->format==HmnConstantDefine::LESSON_YOUTUBE){
									$obj_lesson['obj_data']=get_youtube_id($model->link_youtube,false);
								} 
                            	
								Yii::import('common.content_type.lesson.LessonObject');
								
								$root_object=new Object();
								LessonObject::setValueForObjectLesson($root_object, $obj_lesson,FALSE);								
								if($root_object->save()){
									$lesson = new LessonObject();
									$obj_lesson['object_root_id']=$root_object->object_id;
									LessonObject::setValueForObjectLesson($lesson, $obj_lesson,true);									
									if($lesson->save()){										
										//Start Saving the Term for the lesson
										$term = new ObjectLessonTerm();
										$term->object_id=$root_object->object_id;
										$term->term_id=$obj_lesson['cat'];
										$term->save();
										user()->setFlash('success',t('Cảm ơn bạn đã chia sẻ bài với '.ConstantDefine::SITE_NAME_URL.'! Bạn của bạn sẽ được đăng sau khi được kiểm duyệt bởi đội ngũ Mod của chúng tôi.'));
										Yii::app()->controller->redirect(bu().'/share');																								
									} else {
										$root_object->delete();
										$model->addError('name', 'Có lỗi trong quá trình lưu bài');
									}
								} else {
									$model->addError('name', 'Có lỗi trong quá trình lưu bài');
								}
								
                              	
								
                            } 
                                    
                    }  
					
					
           		 $this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model));
            } else {
                echo '';
            }
      
        
	
       
    }
    
    public function validate(){	
		return true ;
    }
    
    public function params()
    {
         return array();
    }
    
    public function beforeBlockSave(){
	return true;
    }
    
    public function afterBlockSave(){
	return true;
    }
}

?>