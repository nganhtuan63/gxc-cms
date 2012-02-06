<?php

/**
 * This is the model class for table "{{object}}".
 *
 * The followings are the available columns in table '{{object}}':
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
class ArticleObject extends Object
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Object the static model class
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
		return '{{object}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return CMap::mergeArray(array(),Object::extraRules());
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return CMap::mergeArray(array(),Object::extraRelationships());
	}

        /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return CMap::mergeArray(array(),Object::extraLabel());
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		return Object::extraSearch($this);
	}
        
        protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{				
				$this->object_type='article';
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
              return Object::Resources();
        }
        
        public static function Permissions(){
              return Object::Permissions();
        }
}