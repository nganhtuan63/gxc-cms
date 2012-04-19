<?php echo "<?php\n"; ?>

class <?php echo $this->contentClass;?> extends Object
{

	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Object the static model class
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
		return '{{object}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return CMap::mergeArray(array(),Object::extraRules());
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return CMap::mergeArray(array(),Object::extraRelationships());
	}

     /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return CMap::mergeArray(array(),Object::extraLabel());
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		return Object::extraSearch($this);
	}
        
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{				
				$this->object_type='<?php echo strtolower($this->contentName);?>';
                Object::extraBeforeSave('create',$this);
                                
			} else {
				Object::extraBeforeSave('update',$this);
												
			}
			return true;
		}
		else
			return false;
	}
        
        public static function Resources(){

        
              return CMap::mergeArray(Object::Resources(),
				array(                      		   	                  
					'video'=>array('type'=>'video',
		              'name'=>'Video',
		              'maxSize'=>ConstantDefine::UPLOAD_MAX_SIZE, 
		              'minSize'=>ConstantDefine::UPLOAD_MIN_SIZE,
		              'max'=>1,
		              'allow'=>array('flv',
		                             'mp4',)))
				);

        }
        
        public static function Permissions(){
              return Object::Permissions();
        }
        
        public static function buildLink($obj){						
		if($obj->object_id)
			return FRONT_SITE_URL."/post?id=".$obj->object_id."&slug=".$obj->object_slug;
		else 
			return null;
			}
}