<?php

/**
 * This is the model class for table "{{hmn_object_lesson}}".
 *
 * The followings are the available columns in table '{{hmn_object_lesson}}':
 * @property string $object_id
 * @property string $object_author
 * @property integer $object_date
 * @property integer $object_date_gmt
 * @property string $object_content
 * @property string $object_title
 * @property string $object_excerpt
 * @property integer $object_status
 * @property integer $comment_status
 * @property string $object_password
 * @property string $object_name
 * @property integer $object_modified
 * @property integer $object_modified_gmt
 * @property string $object_content_filtered
 * @property string $object_parent
 * @property string $guid
 * @property string $object_type
 * @property string $comment_count
 * @property string $object_slug
 * @property string $object_description
 * @property string $object_keywords
 * @property integer $lang
 * @property string $object_author_name
 * @property integer $total_number_meta
 * @property integer $total_number_resource
 * @property string $tags
 * @property integer $object_view
 * @property integer $like
 * @property integer $dislike
 * @property integer $rating_scores
 * @property double $rating_average
 * @property string $layout

 */
class LessonObject extends Object
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ObjectSale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hmn_object_lesson}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finish','required'),
			array('total_number_meta, total_number_resource, obj_image,obj_data', 'safe'),
			array('object_date, object_date_gmt, object_status, comment_status, object_modified, object_modified_gmt, lang, total_number_meta, total_number_resource, object_view, like, dislike, rating_scores', 'numerical', 'integerOnly'=>true),
			array('rating_average,object_root_id', 'numerical'),
			array('object_author, object_password, object_parent, object_type, comment_count', 'length', 'max'=>20),
			array('object_name, guid, object_slug, object_author_name,source', 'length', 'max'=>255),
			array('format', 'length', 'max'=>50),		
			array('layout', 'length', 'max'=>125),
			array('source', 'length', 'max'=>255),								
			array('raw_content,object_content, object_title, object_excerpt, object_content_filtered, object_description, object_keywords, tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('object_id, object_author, object_date, object_date_gmt, object_content, object_title, object_excerpt, object_status, comment_status, object_password, object_name, object_modified, object_modified_gmt, object_content_filtered, object_parent, guid, object_type, comment_count, object_slug, object_description, object_keywords, lang, object_author_name, total_number_meta, total_number_resource, tags, object_view, like, dislike, rating_scores, rating_average, layout', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                                        
                );
    }
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return CMap::mergeArray(
                Object::extraLabel(),    
				array(
								
				)
                
                );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $criteria=new CDbCriteria;
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('object_author',$this->object_author,true);
		$criteria->compare('object_date',$this->object_date);		
		$criteria->compare('object_content',$this->object_content,true);
		$criteria->compare('object_title',$this->object_title,true);		
		$criteria->compare('object_status',$this->object_status);
                
                $sort = new CSort;
                $sort->attributes = array(
                        'object_id',
                );
                $sort->defaultOrder = 'object_id DESC';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort
		));
	}
        
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{				
				$this->object_type='lesson';
                Object::extraBeforeSave('create',$this);
                                
			} else {
				Object::extraBeforeSave('update',$this);
												
			}
			return true;
		}
		else
			return false;
	}
        
          
        public static function Resources(){
              return array();
        }
        
        public static function Permissions(){
              return Object::Permissions();
        }
		
		 /**
         * Excute after Delete Object
         */
        protected function afterDelete()
        {
                parent::afterDelete();
                ObjectLessonTerm::model()->deleteAll('object_id = :tid',
                                        array(':tid'=>$this->object_id));
               			
			
        }
		
		 public static function setValueForObjectLesson(&$find_object,$lesson_obj,$is_object_lesson=true){
            	
            $find_object->object_name=$find_object->object_title=$lesson_obj['name'];    
			$find_object->object_content=$lesson_obj['content'];
			       
            $find_object->object_excerpt
            =$find_object->object_description
            =$lesson_obj['description'] ;          

            $find_object->object_slug
            =toSlug($lesson_obj['name']);

            $find_object->total_number_meta=1;
            $find_object->total_number_resource=1;

            $find_object->object_author_name=user()->getModel()->display_name;

            $find_object->object_status= ConstantDefine::OBJECT_STATUS_PENDING;

            if($is_object_lesson){
            	$find_object->raw_content=$lesson_obj['raw'];
            	$find_object->source=$lesson_obj['source'];
				$find_object->format=$lesson_obj['format'];
				$find_object->finish=$lesson_obj['finish'];
				$find_object->obj_data=$lesson_obj['obj_data'];
				$find_object->object_root_id=$lesson_obj['object_root_id'];
			}
  
        }
}