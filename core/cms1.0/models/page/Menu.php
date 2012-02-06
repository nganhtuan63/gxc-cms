<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $menu_description
 * @property integer $lang
 */
class Menu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_name, menu_description', 'required'),
			array('lang', 'numerical', 'integerOnly'=>true),
			array('menu_name, menu_description', 'length', 'max'=>255),
                        array('guid','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, menu_name, menu_description, lang', 'safe', 'on'=>'search'),
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
			'menu_id' => t('Menu'),
			'menu_name' => t('Menu Name'),
			'menu_description' => t('Menu Description'),
			'lang' => t('Lang'),
		);
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
        
        protected function afterDelete()
        {
            MenuItem::model()->deleteAll('menu_id = :id',array(':id'=>$this->menu_id));
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

		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('menu_description',$this->menu_description,true);
		$criteria->compare('lang',$this->lang);

                $sort = new CSort;
                $sort->attributes = array(
                        'menu_id',
                );
                $sort->defaultOrder = 'menu_id DESC';
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort
		));
	}
        
         public static function getMenu(){
            $menus=Menu::model()->with('language')->findAll();                        
            $data=array(0=>t("None"));
            if($menus && count($menus) > 0 ){
               foreach($menus as $t){
                    $data[$t->menu_id]=$t->menu_name.' - '.$t->language->lang_desc ;
                }
            }
            
            return $data;
        }
}