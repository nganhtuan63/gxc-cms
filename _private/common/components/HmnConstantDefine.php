
<?php

/**
 * Class defined all the Constant value of the OSG.
 * 
 * 
 * @author Tuan Nguyen
 * @version 1.0
 * @package common.components
 */

class HmnConstantDefine{
	
	/** Constant related Lesson */
	const LESSON_LINK=1;
	const LESSON_YOUTUBE=2;
	const LESSON_WRITING=3;
	const LESSON_SLIDE=4;
	
	const IMGUR_API_KEY='c7aafa47567e70c91d4fc668c9e8b404';
	
    
    public static function getLessonTypes(){
        return array(            
            self::LESSON_YOUTUBE=>t("Youtube video"),
			self::LESSON_WRITING=>t("Bài viết"),            
			);
    }
	
	/** Constant related Lesson Finish */
	const LESSON_NOT_FINISH=0;
	const LESSON_FINISH=1;
	
    
    public static function getLessonFinish(){
        return array(            
            self::LESSON_NOT_FINISH=>t("Đã hoàn chỉnh"),
			self::LESSON_FINISH=>t("Chưa hoàn chỉnh"),            
			);
    }
	
	const LESSON_TAXONOMY=1;
	
	public static function getLessonTerms(){
		
		
			$cat=Yii::app()->cache->get('lesson-cats');
			if($cat===false){
				//Get first level Terms
				$first_terms=Term::model()->findAll(
				array(
				'order'=>'t.order ASC',
				'condition'=>'taxonomy_id = :taxonomy and parent = 0',
				'params'=>array(':taxonomy'=>self::LESSON_TAXONOMY)		
				));
						
				if($first_terms){
					foreach($first_terms as $first){
						$cat[$first->term_id]=$first->name;										
					}
				}
				
				Yii::app()->cache->set('lesson-cats',$cat,21600);
			}
					
		return $cat;
	}
	
}


