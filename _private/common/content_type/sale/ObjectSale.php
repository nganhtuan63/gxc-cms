<?php

/**
 * This is the model class for table "{{osg_object_sale}}".
 *
 * The followings are the available columns in table '{{osg_object_sale}}':
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
 * @property integer $obj_brand_id
 * @property string $obj_brand_name
 * @property string $obj_regular_price
 * @property string $obj_sale_price
 * @property integer $obj_sale_percent
 * @property string $obj_link
 * @property string $obj_image
 * @property string $obj_onsite_id
 * @property string $obj_color_id
 */
class ObjectSale extends Object
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
		return '{{osg_object_sale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total_number_meta, total_number_resource, obj_brand_id, obj_brand_name_id,  obj_brand_name, obj_regular_price, obj_sale_price, obj_sale_percent, obj_link, obj_image, obj_onsite_id, obj_color_id', 'safe'),
			array('object_date, object_date_gmt, object_status, comment_status, object_modified, object_modified_gmt, lang, total_number_meta, total_number_resource, object_view, like, dislike, rating_scores, obj_brand_id, obj_sale_percent', 'numerical', 'integerOnly'=>true),
			array('rating_average,obj_expired', 'numerical'),
			array('object_author, object_password, object_parent, object_type, comment_count', 'length', 'max'=>20),
			array('object_name, guid, object_slug, object_author_name, obj_brand_name, obj_color_id', 'length', 'max'=>255),
			array('layout', 'length', 'max'=>125),
			array('obj_regular_price, obj_sale_price', 'length', 'max'=>10),
			array('obj_onsite_id', 'length', 'max'=>200),
			array('obj_sale_type,object_content, object_title, object_excerpt, object_content_filtered, object_description, object_keywords, tags,obj_detail_html_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('object_id, object_author, object_date, object_date_gmt, object_content, object_title, object_excerpt, object_status, comment_status, object_password, object_name, object_modified, object_modified_gmt, object_content_filtered, object_parent, guid, object_type, comment_count, object_slug, object_description, object_keywords, lang, object_author_name, total_number_meta, total_number_resource, tags, object_view, like, dislike, rating_scores, rating_average, layout, obj_brand_id, obj_brand_name, obj_regular_price, obj_sale_price, obj_sale_percent, obj_link, obj_image, obj_onsite_id, obj_color_id', 'safe', 'on'=>'search'),
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
                    'color' => array(self::BELONGS_TO, 'Color', 'obj_color_id'),
                    
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
			
			'obj_brand_id' => t('Obj Brand'),
			'obj_brand_name' => t('Obj Brand Name'),
                        'obj_brand_name_id' => t('Obj Brand Name Id'),
			'obj_regular_price' => t('Obj Regular Price'),
			'obj_sale_price' => t('Obj Sale Price'),
			'obj_sale_percent' => t('Obj Sale Percent'),
			'obj_link' => t('Obj Link'),
			'obj_image' => t('Obj Image'),
			'obj_onsite_id' => t('Obj Onsite'),
			'obj_color_id' => t('Obj Color'),
                        'obj_sale_type' => t('Sale Type'),
                        'obj_expired' => t('Expired Date'),
                        'obj_detail_html_id'=>'Detail HTML Id'
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
				$this->object_type='sale';
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
}