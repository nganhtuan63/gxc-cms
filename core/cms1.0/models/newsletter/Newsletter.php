<?php

/**
 * This is the model class for table "{{newsletter}}".
 *
 * The followings are the available columns in table '{{newsletter}}':
 * @property string $newsletter_id
 * @property string $topic
 * @property string $content
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_time
 */
class Newsletter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Newsletter the static model class
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
		return '{{newsletter}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topic, content', 'required'),
			array('newsletter_id', 'length', 'max'=>20),
			array('topic', 'length', 'max'=>256),
			array('status', 'in', 'range'=>array(ConstantDefine::NEWSLETTER_STATUS_DRAFT,ConstantDefine::NEWSLETTER_STATUS_SENT)),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('newsletter_id, topic, content, status, created_time, updated_time', 'safe', 'on'=>'search'),
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
			'newsletter_id' => 'Newsletter',
			'topic' => 'Topic',
			'content' => 'Content',
			'status' => 'Status',
			'created_time' => 'Created Time',
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

		$criteria->compare('newsletter_id',$this->newsletter_id,true);
		$criteria->compare('topic',$this->topic,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getStatus($status)
	{
		switch($status)
		{
			case ConstantDefine::NEWSLETTER_STATUS_SENT :
				return t('Sent');
			case ConstantDefine::NEWSLETTER_STATUS_DRAFT :
				return t('Draft');
		}
		return t('Not defined');
	}
	
	/** 
	 * @see CActiveRecord::beforeSave()
	 * Update created_time or updated_time before saving
	 * @return Boolean true if saved successfully, otherwise return false
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_time = time();
			}
			else 
			{
				$this->updated_time = time();	
			}
			return true;
		}
		return false;
    	
	}
}