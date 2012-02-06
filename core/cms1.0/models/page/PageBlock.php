<?php

/**
 * This is the model class for table "{{page_block}}".
 *
 * The followings are the available columns in table '{{page_block}}':
 * @property integer $page_id
 * @property integer $block_id
 * @property integer $block_order
 * @property integer $active
 */
class PageBlock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PageBlock the static model class
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
		return '{{page_block}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, block_id, block_order', 'required'),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, block_id, block_order, status', 'safe', 'on'=>'search'),
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
                    'block' => array(self::BELONGS_TO, 'Block', 'block_id'),
                ); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => t('Page'),
			'block_id' => t('Block'),
			'block_order' => t('Block Order'),
			'status' => t('Status'),
                        'region' => t('Region'),
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

		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('block_id',$this->block_id);
		$criteria->compare('block_order',$this->block_order);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public static function convertPageBlockStatus($value){
                $status=ConstantDefine::getPageBlockStatus();
                if(isset($status[$value])){
                    return $status[$value];
                } else {
                    return t('undefined');
                }
        }
}