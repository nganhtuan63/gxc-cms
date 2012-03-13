<?php

/**
 * This is the model class for table "{{menu_item}}".
 *
 * The followings are the available columns in table '{{menu_item}}':
 * @property integer $menu_item_id
 * @property integer $menu_id
 * @property string $name
 * @property string $type
 * @property string $value
 */
class MenuItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MenuItem the static model class
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
		return '{{menu_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id, name, type, value', 'required'),
			array('menu_id, parent', 'numerical', 'integerOnly'=>true),
			array('name, type, description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_item_id, menu_id, name, type, value', 'safe', 'on'=>'search'),
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
			'menu_item_id' => t('Menu Item'),
			'menu_id' => t('Menu'),
			'name' => t('Name'),
			'type' => t('Type'),
			'value' => t('Value'),
                        'parent' => t('Parent'),
                        'order' => t('Order'),
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

		$criteria->compare('menu_item_id',$this->menu_item_id);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        protected function beforeSave(){
            if(parent::beforeSave())
            {
                    if($this->isNewRecord)
                    {				
                            // If this is the new Menu Item, we will find the Max Value of Order of 
                           
                            $this->order=
                            $command=$this->dbConnection
                            ->createCommand("SELECT MAX(`order`)+1 FROM gxc_menu_item where menu_id = :tid and parent = :pid ")
                                    ->bindValue(':tid',$this->menu_id,PDO::PARAM_STR)
                                    ->bindValue(':pid',$this->parent,PDO::PARAM_STR)
                                    ->queryScalar();
                            
                    }
                    return true;
            }
            else
                    return false;
        }
        
        public static function getMenuItemFromMenu($menu_id,$render=true){
                        
                $menus=MenuItem::model()->findAll('menu_id = :id',array(':id'=>$menu_id));                
                $data=array(0=>t("None"));                
                if($menus && count($menus) > 0 ){
                    $data=CMap::mergeArray($data,CHtml::listData($menus,'menu_item_id','name'));   
                }                
                if($render){
                    foreach($data as $value=>$name)
                    {
                        echo CHtml::tag('option',
                                   array('value'=>$value),CHtml::encode($name),true);
                    }
                } else {
                    return $data;
                }
                
        }
        
        
        public static function ajaxDeleteModel($id){
            if(Yii::app()->request->isPostRequest){
                
                    //First make sure that there is no children category
                    $model=GxcHelpers::loadDetailModel('MenuItem', $id);                                      
                    if($model->delete()){
                        echo json_encode(array('result'=>t('success'),'message'=>''));
                    } else {
                        echo json_encode(array('result'=>t('error'),'message'=>t('Error while Deleting!')));
                    }
                  
            } else {
                    echo json_encode(array('result'=>t('error'),'message'=>t('Error! Invalid Request!')));
            }
            Yii::app()->end();
        }
        
        
        public static function ajaxChangeOrder(){
            if(Yii::app()->request->isPostRequest){       
                    if( isset($_POST['data']) && (strpos($_POST['data'],"li_item_id[]")!==false)){                        
                        
                        $string_explode_order=explode("&",$_POST['data']);
                        $order=array();            
                        
                        foreach($string_explode_order as $order_item){
                            $order_explode=explode("=",$order_item);
                            if(isset($order_explode[1]) && $order_explode[1]!=0)
                                $order[]=$order_explode[1];
                        }
                        
                        $command = Yii::app()->db->createCommand();                    
                        foreach($order as $order=>$id){
                            
                            $command->update('gxc_menu_item', array(
                                'order'=>$order+1,
                            ),  'menu_item_id=:id', array(':id'=>$id));

                        }
                        echo json_encode(array('result'=>t('success'),'message'=>''));
                    } else {
                        echo json_encode(array('result'=>t('error'),'message'=>t('Error! Invalid Input Data')));                                                                         
                    }
            }                  
            else {
                    echo json_encode(array('result'=>t('error'),'message'=>t('Error! Invalid Request!')));
            }
            Yii::app()->end();
        }
        
        
        
        public static function suggestTerm(){
            if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
                {         
                         $limit=10;
                         $terms=Term::model()->findAll(array(
                                'condition'=>'name LIKE :keyword',
                                'limit'=>$limit,
                                'params'=>array(
                                        ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                                ),
                        ));
                        $names=array();
                        foreach($terms as $term){
                            $names[]=$term->name.'-'.$term->description.'-'.$term->term_id.'|'.$term->term_id;
                        }
                                                
                        if($names!==array())
                            echo implode("\n",$names);

                }
                Yii::app()->end();
        }
		
		public static function suggestContent(){
			 $keyword='';
			 if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!==''){
             	$names=Object::model()->suggestContent($keyword);
				if($names!==array())
                            echo implode("\n",$names);
             }
			 Yii::app()->end();
		}
        
        public static function ReBindValueForMenuType($type,$value){
            
            $result='';
            switch($type){
                case ConstantDefine::MENU_TYPE_PAGE:
                    $page=Page::model()->findByPk($value);
                    if($page) $result=$page->name;                    
                    break;
                case ConstantDefine::MENU_TYPE_TERM:
                    $term=Term::model()->findByPk($value);
                    if($term) $result=$term->name;
                    
                    break;
            }
            
            return $result;
        }
        
}