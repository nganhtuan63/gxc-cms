<?php

/**
 * This is the model class for table "{{content_list}}".
 *
 * The followings are the available columns in table '{{content_list}}':
 * @property string $content_list_id
 * @property string $name
 * @property string $value
 * @property integer $created
 */
class ContentList extends CActiveRecord
{
        // This list is manual or auto
        public $type;
        
        // Language of the Object
        public $lang;
        
        // Content type we want to get
        public $content_type;
        
        //Object Terms
        public $terms;
        
        //Object Tags
        public $tags;
        
        //=0 means no paging, >0 means item per pages
        public $paging;
        
        //Number Items to get
        public $number;
               
        // Criteria of the list 
        public $criteria;
        
               
        // Manual List
        public $manual_list;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContentList the static model class
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
		return '{{content_list}}';
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
			array('type,lang,content_type,terms,tags,paging,number,criteria,manual_list','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('content_list_id, name, value, created', 'safe', 'on'=>'search'),
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
			'content_list_id' => t('Content List'),
			'name' => t('Name'),
			'value' => t('Value'),
			'created' => t('Created'),
                    
                        'type'=> t('Type'),
                        'lang'=> t('Language'),
                        'content_type'=> t('Content type'),
                        'terms'=> t('Terms'),
                        'tags'=> t('Tags'),
                        'paging'=> t('Paging'),
                        'number'=> t('Number'),
                        'criteria'=> t('Criteria'),
                        'manual_list'=> t('Manual List'),
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

		$criteria->compare('content_list_id',$this->content_list_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('created',$this->created);

                $sort = new CSort;
                $sort->attributes = array(
                        'content_list_id',
                );
                $sort->defaultOrder = 'content_list_id DESC';
                
                
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
				$this->created=time();                           
                                
			} 
                        
                        // We need to start to convert all the 
                        // Model attributes to array for serialize to the value 
                        
                        $arr['type']=$this->type;
                        $arr['lang']=$this->lang;
                        $arr['content_type']=$this->content_type;
                        $arr['terms']=$this->terms;
                        $arr['tags']=$this->tags;
                        $arr['paging']=$this->paging;
                        $arr['number']=$this->number;
                        $arr['criteria']=$this->criteria;                        
                        $arr['manual_list']=$this->manual_list;     
                        $this->value=serialize($arr);
                        
                        return true;
		}
		else
			return false;
	}
        
        protected function afterFind(){
             parent::afterFind();
             
             $arr=unserialize($this->value);
             
             $this->type=isset($arr['type']) ? $arr['type'] : ConstantDefine::CONTENT_LIST_TYPE_MANUAL;
             $this->lang=isset($arr['lang']) ? $arr['lang'] : '0';
             $this->content_type=isset($arr['content_type']) ? $arr['content_type'] : 'all';
             $this->terms=isset($arr['terms']) ? $arr['terms'] : '0';
             $this->tags=isset($arr['tags']) ? $arr['tags'] : '';
             $this->paging=isset($arr['paging']) ? $arr['paging'] : 0;
             $this->number=isset($arr['number']) ? $arr['number'] : 1;
             $this->criteria=isset($arr['criteria']) ? $arr['criteria'] : '';
             $this->manual_list=isset($arr['manual_list']) ? $arr['manual_list'] : array();
             
        }
        
        public static function getContentType(){            
            $types= GxcHelpers::getAvailableContentType();
                       
            $result=array('all'=>t('All'));
            foreach($types as $key=>$value){
               $result[$key]=$value['name']; 
            }
            return $result;    
        }
        
        public static function getContentLang(){                           
            $result=array('0'=>t('All'));
            $result=CMap::mergeArray($result,  Language::items());          
            return $result;    
        }
        
        public static function getDynamicTerms(){
            
            $type=isset($_POST['q']) ? $_POST['q'] : array('0') ;	   
            $lang=isset($_POST['lang']) ? $_POST['lang'] : array('0') ;
            
	    if(in_array('all',$type)){
                if (in_array('0',$lang)) {
                    $data=Term::model()->findAll();
                }
                else {
                    $data=Term::model()->with('taxonomy')->findAll('lang IN ('.implode(",",$lang).')');
                }
	    } else {
		$str=(implode("','",$type));
		$str="'".$str."'";	
                if (in_array('0',$lang)) {
                    $data=Term::model()->with('taxonomy')->findAll('type IN ('.$str.')',array());
                } else {
                     $data=Term::model()->with('taxonomy')->findAll('type IN ('.$str.') and lang IN ('.implode(",",$lang).')',array());
                }
	    }	  
	 
	    $data=CHtml::listData($data,'term_id','name');
	    if(count($data)<0){
		echo CHtml::tag('option',
			   array('value'=>0,'selected'=>'selected'),t('All'),true);
	    } else {
                    echo CHtml::tag('option',
                    array('value'=>0,'selected'=>'selected'),t('All'),true);
		foreach($data as $value=>$name)
		{
                    echo CHtml::tag('option',
                    array('value'=>$value),CHtml::encode($name),true);
		}
	    }
        }
        
        
        public static function suggestTags(){
            if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
        }
        
        public static function suggestContent(){
            if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$type=isset($_GET['type']) ?  trim($_GET['type']) : '';
			$tags=Object::model()->suggestContent($keyword,$type);
			if($tags!==array())
				echo implode("\n",$tags);
		}
        }
        
        public static function getTerms(){            
		$terms = Term::model()->findAll();
		$result = array('0'=>t('All'));
		foreach ($terms as $term) {
			$result[$term->term_id] = $term->name;	
		}			
		return $result;
	
        }
}