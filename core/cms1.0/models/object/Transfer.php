<?php

/**
 * This is the model class for table "{{transfer}}".
 *
 * The followings are the available columns in table '{{transfer}}':
 * @property string $transfer_id
 * @property string $object_id
 * @property string $from_user_id
 * @property string $to_user_id
 * @property integer $before_status
 * @property integer $after_status
 * @property integer $type
 * @property string $note
 * @property integer $time
 * @property integer $time_gmt
 */
class Transfer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Transfer the static model class
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
		return '{{transfer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id, from_user_id, to_user_id, before_status, after_status, type, time', 'safe'),			
			array('transfer_id, object_id, from_user_id, to_user_id, before_status, after_status, type, note, time', 'safe', 'on'=>'search'),
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
			'from_user' => array(self::BELONGS_TO, 'User', 'from_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transfer_id' => t('Transfer'),
			'object_id' => t('Object'),
			'from_user_id' => t('From User'),
			'to_user_id' => t('To User'),
			'before_status' => t('Before Status'),
			'after_status' => t('After Status'),
			'type' => t('Type'),
			'note' => t('Note'),
			'time' => t('Time'),
			
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

		$criteria->compare('transfer_id',$this->transfer_id,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('from_user_id',$this->from_user_id,true);
		$criteria->compare('to_user_id',$this->to_user_id,true);
		$criteria->compare('before_status',$this->before_status);
		$criteria->compare('after_status',$this->after_status);
		$criteria->compare('type',$this->type);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('time',$this->time);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->time=time();
			
			return true;
		}
		else
			return false;
	}
}