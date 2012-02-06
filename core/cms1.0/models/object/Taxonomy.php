<?php

/**
 * This is the model class for table "{{taxonomy}}".
 *
 * The followings are the available columns in table '{{taxonomy}}':
 * @property string $taxonomy_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $count
 * @property integer $lang
 */
class Taxonomy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Taxonomy the static model class
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
		return '{{taxonomy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,description', 'required'),
			array('lang', 'numerical', 'integerOnly'=>true),                    
			array('name, type', 'length', 'max'=>255),
                        array('guid','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('taxonomy_id, name, description, type, lang, guid', 'safe', 'on'=>'search'),
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
                    'language' => array(self::BELONGS_TO, 'Language', 'lang'),
                ); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'taxonomy_id' => t('Taxonomy id'),
			'name' => t('Name'),
			'description' => ('Description'),
			'type' => t('Type'),			
			'lang' => t('Lang'),
                        'guid' => t('Guid')
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

		$criteria->compare('taxonomy_id',$this->taxonomy_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type,true);		
		$criteria->compare('lang',$this->lang);
                $criteria->compare('guid',$this->lang);

                $sort = new CSort;
                $sort->attributes = array(
                        'taxonomy_id',
                );
                $sort->defaultOrder = 'taxonomy_id DESC';
                
                
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
				if($this->guid==''){
                                    $this->guid=uniqid();
                                }                             
                                
			} 
			return true;
		}
		else
			return false;
	}
        
        public static function getTaxonomy(){
            $taxonomy=Taxonomy::model()->with('language')->findAll();
                        
            $data=array(0=>t("None"));
            if($taxonomy && count($taxonomy) > 0 ){
               foreach($taxonomy as $t){
                    $data[$t->taxonomy_id]=$t->name.' - '.$t->language->lang_desc ;
                }
            }
            
            return $data;
        }

        
        
         
}