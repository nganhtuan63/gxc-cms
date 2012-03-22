<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property string $comment_id
 * @property string $object_id
 * @property string $topic
 * @property string $content
 * @property integer $status
 * @property string $author_name
 * @property string $email
 * @property integer $create_time
 */
class Comment extends CActiveRecord
{
	//verify captcha code
	public $verifyCode;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topic, content, author_name, email', 'required'),
			array('status, create_time', 'numerical', 'integerOnly'=>true),
			array('object_id', 'length', 'max'=>20),
			array('topic', 'length', 'max'=>256),
			array('author_name, email', 'length', 'max'=>128),
			array('email', 'email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, object_id, topic, content, status, author_name, email, create_time', 'safe', 'on'=>'search'),
				array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'comment_id' => 'Comment',
			'object_id' => 'Object',
			'topic' => 'Topic',
			'content' => 'Content',
			'status' => 'Status',
			'author_name' => 'Author Name',
			'email' => 'Email',
			'create_time' => 'Create Time',
			'verifyCode' => 'Verification Code',
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

		$criteria->compare('comment_id',$this->comment_id,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('topic',$this->topic,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('author_name',$this->author_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getStatus($status)
	{
		switch($status)
		{
			case ConstantDefine::COMMENT_STATUS_PUBLISHED :
				return t('Published');
			case ConstantDefine::COMMENT_STATUS_PENDING :
				return t('Pending');
			case ConstantDefine::COMMENT_STATUS_DISCARDED :
				return t('Discarded');
		}
		return 'Not defined';
	}
	
	/* 
	 * Before saving:
	 * 		Update the create_time, status and object_id
	 * 		Increase the object's comment_count by 1
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
    	{
        	if($this->isNewRecord)
        	{
        		//Update the create_time, status and object_id
            	$this->create_time=time();
            	$this->status = ConstantDefine::COMMENT_STATUS_PENDING;
            	$this->object_id = (int)$_GET['id'];
            	
            	//Increase the object's comment_count by 1
            	$object = Object::model()->findByPk($this->object_id);
            	if($object !=null)
            	{
            		$object->increaseCommentCount();
            	}
            	else 
            		return false;
        	}
        	return true;
    	}
    	else 
    		return false;
	}
}