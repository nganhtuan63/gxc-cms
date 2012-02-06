<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property string $page_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $parent
 * @property string $layout
 * @property string $slug
 * @property integer $lang
 */
class Page extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Page the static model class
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
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, title, description, parent, layout, slug, lang', 'required'),
			array('lang, status, allow_index, allow_follow', 'numerical', 'integerOnly'=>true),
			array('name, title, description, layout, slug, keywords', 'length', 'max'=>255),
			array('parent', 'length', 'max'=>20),
                        array('guid','safe'),
                        array('display_type','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, name, title, description, parent, layout, slug, lang', 'safe', 'on'=>'search'),
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
			'page_id' => t('Page'),
			'name' => t('Name'),
			'title' => t('Title'),
			'description' => t('Description'),
			'parent' => t('Parent'),
			'layout' => t('Layout'),
			'slug' => t('Slug'),
			'lang' => t('Lang'),
                        'guid' => t('Guid'),
                        'status' => t('Status'),
                        'keywords' => t('Keywords'),
                        'allow_index' => t('Allow index page'),
                        'allow_follow' => t('Allow follow page'),
                        'display_type' => t('Display type'),
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

		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('lang',$this->lang);
                
                $sort = new CSort;
                $sort->attributes = array(
                        'page_id',
                );
                $sort->defaultOrder = 'page_id DESC';
                

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
        
        protected function afterDelete()
        {
             PageBlock::model()->deleteAll('page_id = :id',array(':id'=>$this->page_id));
               	
        }
        
         public static function getParentPages($render=true,$page_id=null){                        
                if($page_id!==null){
                    $pages=Page::model()->findAll('status = :status and page_id <> :pid',array(':status'=>  ConstantDefine::PAGE_ACTIVE,':pid'=>$page_id));                
                }
                else {
                    $pages=Page::model()->findAll('status = :status',array(':status'=>  ConstantDefine::PAGE_ACTIVE));                
                }
                
                $data=array(0=>t("None"));      
                
                
                if($pages && count($pages) > 0 ){
                    $data=CMap::mergeArray($data,CHtml::listData($pages,'page_id','name'));                        
                    
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
        
        public static function changeLayout(){
            $layout=isset($_POST['layout']) ? $_POST['layout'] : 'default';            
            
            $result=array();
            $result['layout']=$layout;
            $result['regions']=array();                        
            $available_layouts=GxcHelpers::getAvailableLayouts(false);            
            $result['regions'] = isset($available_layouts[$layout]['regions']) ? $available_layouts[$layout]['regions'] : 
                    $available_layouts['default']['regions'] ;
            
            $result['types'] = isset($available_layouts[$layout]['types']) ? $available_layouts[$layout]['types'] : 
                    $available_layouts['default']['types'] ;
                        
            echo json_encode($result); 
            
        }
        
        public static function changeParent(){            
            $layout='default';
            $parent=isset($_POST['parent']) ? $_POST['parent'] : 0;
            
            $result=array();
            $result['layout']=$layout;
            $result['regions']=array();
            $result['blocks']=array();
            //From here, we will start to get the layouts info
            $available_layouts=GxcHelpers::getAvailableLayouts(false);
            if($parent){
                $page=Page::model()->findByPk($parent);
                if($page){
                    $result['layout']=$layout=$page->layout;
                    
                    //We now find all blocks of this parent
                     $page_blocks=PageBlock::model()->with('block')->findAll(
                                array(
                                    'condition'=>'page_id = :pid',
                                    'params'=>array(':pid'=>$parent),
                                    'order'=>'region ASC, block_order ASC'
                                )
                                );

                        foreach($page_blocks as $pb){
                            $temp['region']=$pb->region;
                            $temp['id']=$pb->block_id;
                            $temp['status']=$pb->status;
                            $temp['title']=$pb->block->name;                            
                            $result['blocks'][]=$temp;
                        }
                }
            }
            $result['regions'] = isset($available_layouts[$layout]['regions']) ? $available_layouts[$layout]['regions'] : 
                    $available_layouts['default']['regions'] ;
            
            $result['types'] = isset($available_layouts[$layout]['types']) ? $available_layouts[$layout]['types'] : 
                    $available_layouts['default']['types'] ;
                        
            echo json_encode($result); 
            
        }
        
        public static function inheritParent(){            
            
            $parent=isset($_POST['parent']) ? (int)$_POST['parent'] : 0;
            $region=isset($_POST['region']) ? (int)$_POST['region'] : null;
            $layout=isset($_POST['layout']) ? (int)$_POST['layout'] : '';
            
            $result=array();          
            $result['blocks']=array();
            
            
           
            if($parent && ($region!==null)){
                $page=Page::model()->findByPk($parent);
                if($page){                                        
                    //We now find all blocks of this parent
                     $page_blocks=PageBlock::model()->with('block')->findAll(
                                array(
                                    'condition'=>'page_id = :pid and region = :rid',
                                    'params'=>array(':pid'=>$parent,':rid'=>$region),
                                    'order'=>'region ASC, block_order ASC'
                                )
                                );

                        foreach($page_blocks as $pb){
                            $temp['region']=$pb->region;
                            $temp['id']=$pb->block_id;
                            $temp['status']=$pb->status;
                            $temp['title']=$pb->block->name; 
                            
                            $result['blocks'][]=$temp;
                        }
                }
            }            
                        
            echo json_encode($result); 
            
        }
   
   
        
        public static function suggestPage(){
             if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
                {         
                         $limit=10;
                         $pages=Page::model()->findAll(array(
                                'condition'=>'name LIKE :keyword',
                                'limit'=>$limit,
                                'params'=>array(
                                        ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                                ),
                        ));
                        $names=array();
                        foreach($pages as $page){
                            $names[]=$page->name.'|'.$page->page_id;

                        }
                                                
                        if($names!==array())
                            echo implode("\n",$names);

                }
                Yii::app()->end(); 
        }
        
        public static function getPageName($id){
            if($id){
                $page=Page::model()->findByPk($id);
                if($page){
                    return CHtml::encode($page->name);
                } else{
                    return '';
                }
            } else {
                return '';
            }
        }
        
       
        
}