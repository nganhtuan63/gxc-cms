<?php

/**
 * This is the model class for table "{{object_resource}}".
 *
 * The followings are the available columns in table '{{object_resource}}':
 * @property string $object_id
 * @property string $resource_id
 * @property integer $resource_order
 * @property string $description
 */
class ObjectResource extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ObjectResource the static model class
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
		return '{{object_resource}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resource_order', 'numerical', 'integerOnly'=>true),
			array('object_id, resource_id', 'length', 'max'=>20),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('object_id, resource_id, resource_order, description', 'safe', 'on'=>'search'),
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
			'object_id' => t('Object'),
			'resource_id' => t('Resource'),
			'resource_order' => t('Resource Order'),
			'description' => t('Description'),
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
		$criteria->compare('resource_id',$this->resource_id,true);
		$criteria->compare('resource_order',$this->resource_order);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}