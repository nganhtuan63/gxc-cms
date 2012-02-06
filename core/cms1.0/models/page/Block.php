<?php

/**
 * This is the model class for table "{{block}}".
 *
 * The followings are the available columns in table '{{block}}':
 * @property integer $block_id
 * @property string $name
 * @property string $title
 * @property string $type
 * @property integer $created
 * @property string $creator
 * @property integer $updated
 * @property string $params
 */
class Block extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Block the static model class
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
		return '{{block}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
                        array('creator, updated, params, created','safe'),			
			array('name', 'length', 'max'=>255),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('block_id, name,  type, created, creator, updated', 'safe', 'on'=>'search'),
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
		return array(
			'block_id' => t('Block'),
			'name' => t('Name'),		
			'type' => t('Type'),
			'created' => t('Created'),
			'creator' => t('Creator'),
			'updated' => t('Updated'),
			'params' => t('Params'),
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

		$criteria->compare('block_id',$this->block_id);
		$criteria->compare('name',$this->name,true);	
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('updated',$this->updated);		

                $sort = new CSort;
                $sort->attributes = array(
                        'block_id',
                );
                $sort->defaultOrder = 'block_id DESC';
                
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
				$this->created=$this->updated=time();  
                                $this->creator=user()->getModel()->user_id;
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
             PageBlock::model()->deleteAll('block_id = :id',array(':id'=>$this->block_id));
               	
        }
        
        
        
        public static function getLabel($obj,$attr){
            $labels=$obj->params();
            if(array_key_exists($attr,$labels )){                
                return $labels[$attr];
            } else {
                return $attr;
            }
            
                        
        }
        
        
         public static function suggestBlocks(){
             if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
                {         
                         $limit=10;
                         $blocks=Block::model()->findAll(array(
                                'condition'=>'name LIKE :keyword',
                                'limit'=>$limit,
                                'params'=>array(
                                        ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                                ),
                        ));
                        $names=array();
                        foreach($blocks as $block){
                            $names[]=$block->name.'|'.$block->block_id;

                        }
                                                
                        if($names!==array())
                            echo implode("\n",$names);

                }
                Yii::app()->end(); 
        }
}