<?php

/**
 * This is the model class for table "gxc_resource".
 *
 * The followings are the available columns in table 'gxc_resource':
 * @property string $resource_id
 * @property string $resource_name
 * @property string $resource_body
 * @property string $resource_path
 * @property string $resource_type
 * @property integer $created
 * @property integer $updated
 * @property string $creator
 * @property string $where
 */
class Resource extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Resource the static model class
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
		return '{{resource}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resource_body,creator,resource_name,resource_path,created,updated,where,resource_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resource_id, resource_name, resource_body, resource_path, resource_type, created, updated, creator, ehere', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'creator'),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_id' => t('Id'),
			'resource_name' => t('Resource Name'),
			'resource_body' => t('Resource Body'),
			'resource_path' => t('Resource Path'),
			'resource_type' => t('Type'),
			'created' => t('Created'),
			'updated' => t('Updated'),
			'creator' => t('Author'),
			'where' => t('Storage'),
			
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

		$criteria->compare('resource_id',$this->resource_id,true);
		$criteria->compare('resource_name',$this->resource_name,true);
		$criteria->compare('resource_body',$this->resource_body,true);
		$criteria->compare('resource_path',$this->resource_path,true);
		$criteria->compare('resource_type',$this->resource_type,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('creator',$this->creator,true);

		$sort = new CSort;
                $sort->attributes = array(
                        'resource_id',
                );
                $sort->defaultOrder = 'resource_id DESC';


		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{				
				$this->created=$this->updated=time();
				$this->creator=user()->id;
			} else {
				$this->updated=time();
				
			}
			
			return true;
		}
		else
			return false;
	}
	
	protected function afterDelete()
    {            	    		
            parent::afterDelete();			
			//Delete the file based on its storage
			$storages=GxcHelpers::getStorages(true);			
			$resource_handle= new $storages[$this->where]();									
			$resource_handle->deleteResource($this);			
			ObjectResource::model()->deleteAll('resource_id = :res',
                                           array(':res'=>$this->resource_id));
													   
    }
	
	public function getFullPath(){					   			
			$class_storage=Yii::app()->cache->get('get-storages-cache-'.$this->where);
			if(false===$class_storage){
				$storages = Yii::app()->cache->get('get-storages-cache'); //get cache
				if(false===$storages) {
					$storages=GxcHelpers::getStorages(true);	
					Yii::app()->cache->set('get-storages-cache',$storages,360000);	
				}		    	
				$class_storage=$storages[$this->where];	    
				Yii::app()->cache->set('get-storages-cache-'.$this->where,$class_storage,360000);									
			}	
			return $class_storage::getFilePath($this->resource_path);
	}
	
	
	
	
	
	

}