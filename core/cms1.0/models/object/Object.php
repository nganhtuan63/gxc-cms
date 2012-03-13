<?php

/**
 * This is the model class for table "{{object}}".
 *
 * The followings are the available columns in table '{{object}}':
 * @property string $object_id
 * @property string $object_author
 * @property integer $object_date
 * @property integer $object_date_gmt
 * @property string $object_content
 * @property string $object_title
 * @property string $object_excerpt
 * @property integer $object_status
 * @property integer $comment_status
 * @property string $object_password
 * @property string $object_name
 * @property integer $object_modified
 * @property integer $object_modified_gmt
 * @property string $object_content_filtered
 * @property string $object_parent
 * @property string $guid
 * @property string $object_type
 * @property string $comment_count
 * @property string $object_slug
 * @property string $object_description
 * @property string $object_keywords
 * @property integer $lang
 * @property string $object_author_name
 * @property integer $total_number_meta
 * @property integer $total_number_resource
 * @property string $tags
 * @property integer $object_view
 * @property integer $like
 * @property integer $dislike
 * @property integer $rating_scores
 * @property double $rating_average
 * @property string $layout
 */
class Object extends CActiveRecord
{
        //The old Tags
        public $_oldTags;
        
        //This is to check the person the Object will be transferd to    
        public $person;
        
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
		return self::extraRules();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
                return self::extraRelationships();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return self::extraLabel();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		return self::extraSearch($this);
	}
        
        
        protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				if($this->object_type=='')					
					$this->object_type='object';
                self::extraBeforeSave('create',$this);
                                
			} else {
				self::extraBeforeSave('update',$this);
												
			}
			return true;
		}
		else
			return false;
	}
        
        public static function extraBeforeSave($type='update',$object){
           switch($type){
               case 'update':
                    $current_time=time();
                    $current_time_gmt=local_to_gmt(time());
                    $object->object_modified=$current_time;
                    $object->object_modified_gmt=$current_time_gmt;
                   break;
               case 'create':               
				    if(!isConsoleApp() && user()->id){
                        $object->object_author=user()->id;				
                    } else {
                        $object->object_author=0;				
                    }
                    $current_time=time();
                    $current_time_gmt=local_to_gmt(time());
					$object->object_date=$current_time;
                    $object->object_date_gmt=$current_time_gmt;
                    $object->object_modified=$current_time;
                    $object->object_modified_gmt=$current_time_gmt;                    
                    if($object->guid==''){
                        $object->guid=uniqid();
                    }
                   break;
           }
            
        }
        
        protected function afterSave()
	{
                parent::afterSave();
                self::extraAfterSave($this);				
	}
        
        
        //After Save excucte update Tag Relationship
        public static function extraAfterSave($object){
                self::UpdateTagRelationship($object);
        }
        
        
        /**
         * Excute after Delete Object
         */
        protected function afterDelete()
        {
                parent::afterDelete();
                self::extraAfterDelete($this);
               
			
		//Implements to delete The Term Relation Ship		
        }
        
        public static function extraAfterDelete($object){
                ObjectMeta::model()->deleteAll('meta_object_id = :obj',
                                       array(':obj'=>$object->object_id));
                ObjectResource::model()->deleteAll('object_id = :obj',
                                       array(':obj'=>$object->object_id));

                Transfer::model()->deleteAll('object_id = :obj',
                                       array(':obj'=>$object->object_id));

                TagRelationships::model()->deleteAll('object_id = :tid',
                                        array(':tid'=>$object->object_id));
                
                ObjectTerm::model()->deleteAll('object_id = :tid',
                                        array(':tid'=>$object->object_id));
        }
        /**
         * Update Tag Relationship of the Object
         * @param type $obj 
         */
        public static function UpdateTagRelationship($obj){
				
		Tag::model()->updateFrequency($obj->_oldTags, $obj->tags);
		
		//Start to DElete All the Tag Relationship
		TagRelationships::model()->deleteAll('object_id = :id',array(':id'=>$obj->object_id));
		
		//Start to re Insert
		$explode=explode(',',trim($obj->tags));
		
		foreach($explode as $ex){			
			$tag=Tag::model()->find('slug = :s',array(':s'=>Tag::model()->stripVietnamese(strtolower($ex))));
			if($tag){
				$tag_relationship = new TagRelationships;
				$tag_relationship->tag_id=$tag->id;
				$tag_relationship->object_id=$obj->object_id;
				$tag_relationship->save();
			}
			
		}
	}
        
        /**
         * Get Tags of the Object
         * @param type $object_id
         * @return type 
         */
        public static function getTags($object_id){
                $req = Yii::app()->db->createCommand(
                                    "SELECT t.name 
                                    FROM gxc_tag t, gxc_tag_relationships r, gxc_object o
                                    WHERE t.id = r.tag_id 
                                    AND r.object_id = o.user_id
                                    AND o.user_id = ".$object_id
                );
                $tags_name = $req->queryAll();
                $result = array();
                if ($tags_name != null) {
                    foreach ($tags_name as $tag_name) {
                        $result[] = $tag_name['name'];
                    }
                }
                return $result;
        }
        
        /**
         * get Related content by Tags
         * @param type $id
         * @param type $max
         * @return CActiveDataProvider 
         */
        public static function getRelatedContentByTags($id, $max) {
            $object = Object::loadModel($id);
            $criteria = new CDbCriteria;        
            $criteria->join = 'join gxc_tag_relationships ft on ft.object_id = t.object_id';
            $criteria->condition = 'ft.tag_id in (select tag_id from fcms_tag_relationships fr
                                                where fr.object_id = :id)
                                    AND t.object_id <> :id  
                                    AND t.object_status = :status
                                    AND t.object_date <= :time
                                    AND t.object_type = :type';        
            $criteria->distinct = true;
            $criteria->params = array(':id'=>$id,':status'=>  ConstantDefine::OBJECT_STATUS_PUBLISHED,':time'=>time(),'type'=>$object->object_type);
            $criteria->order = "object_date DESC";
            //$aa = Object::model()->findAll($criteria);
            //$criteria->limit = $max;       

            return new CActiveDataProvider('Object',array(
                                    'criteria'=> $criteria,
                                    'pagination'=>array(
                                            'pageSize'=>$max
                                        )
                                    ));         
        }
    
        /**
         * Normalize The Tags for the Object - Check Valid
         * @param type $attribute
         * @param type $params 
         */
        public function normalizeTags($attribute,$params)
	{
	    $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}
	
	/**
         * Check Tags Valid
         * @param type $attribute
         * @param type $params 
         */
        public function checkTags($attribute,$params)
	{
		$result = $this->tags;
		$regex = "/[\^\[\]\$\.\|\?\*\+\(\)\{\}\/\*\%\!\.\'\"\@\#\&\:\<\>\|\-\_\+\=\`\~\;]/";
		if (preg_match($regex,$result))
			$this->addError('tags',t('Tags must contain characters only'));
		
	}
	
        
        public static function extraSearch($object){
                // Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('object_id',$object->object_id,true);
		$criteria->compare('object_author',$object->object_author,true);
		$criteria->compare('object_date',$object->object_date);		
		$criteria->compare('object_content',$object->object_content,true);
		$criteria->compare('object_title',$object->object_title,true);		
		$criteria->compare('object_status',$object->object_status);					
                
                $sort = new CSort;
                $sort->attributes = array(
                        'object_id',
                );
                $sort->defaultOrder = 'object_id DESC';
                
		return new CActiveDataProvider($object, array(
			'criteria'=>$criteria,
                        'sort'=>$sort
		));
        }
	
        public static function extraLabel(){
                return array(
			'object_id' => t('Object'),
			'object_author' => t('Object Author'),
			'object_date' => t('Object Date'),
			'object_date_gmt' => t('Object Date Gmt'),
			'object_content' => t('Object Content'),
			'object_title' => t('Object Title'),
			'object_excerpt' => t('Object Excerpt'),
			'object_status' => t('Object Status'),
			'comment_status' => t('Comment Status'),
			'object_password' => t('Object Password'),
			'object_name' => t('Object Name'),
			'object_modified' => t('Object Modified'),
			'object_modified_gmt' => t('Object Modified Gmt'),
			'object_content_filtered' => t('Object Content Filtered'),
			'object_parent' => t('Object Parent'),
			'guid' => t('Guid'),
			'object_type' => t('Object Type'),
			'comment_count' => t('Comment Count'),
			'object_slug' => t('Object Slug'),
			'object_description' => t('Object Description'),
			'object_keywords' => t('Object Keywords'),
			'lang' => t('Lang'),
			'object_author_name' => t('Object Author Name'),
			'total_number_meta' => t('Total Number Meta'),
			'total_number_resource' => t('Total Number Resource'),
			'tags' => t('Tags'),
			'object_view' => t('Object View'),
			'like' => t('Like'),
			'dislike' => t('Dislike'),
			'rating_scores' => t('Rating Scores'),
			'rating_average' => t('Rating Average'),
			'layout' => t('Layout'),
                        'person' => t('Person')
		);
        }
        
        public static function extraRules(){
                // NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('total_number_meta, total_number_resource','safe'),
			array('object_name', 'required'),
                        array('object_content','length','min'=>10),
                        array('object_description,object_keywords,object_excerpt,object_title,guid','safe'),
			array('object_date, object_date_gmt, object_status, comment_status, object_modified, object_modified_gmt, lang, total_number_meta, total_number_resource, object_view, like, dislike, rating_scores', 'numerical', 'integerOnly'=>true),
			array('rating_average', 'numerical'),
			array('object_author, object_password, object_parent, object_type, comment_count', 'length', 'max'=>20),
			array('object_name, guid, object_slug, object_keywords, object_author_name', 'length', 'max'=>255),
			array('layout', 'length', 'max'=>125),
			array('tags', 'checkTags'),
			array('tags', 'normalizeTags'),
                        array('person', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('object_id, object_author, object_date, object_content, object_title, object_status, object_name', 'safe', 
                            'on'=>'search,draft,published,pending'),
		);
        }
        
        /**
         * Define Relationships so that its child class can call it
         * @return type 
         */
        public static function extraRelationships(){
                // NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		 return array(
                    'author' => array(self::BELONGS_TO, 'User', 'object_author'),
                    'language' => array(self::BELONGS_TO, 'Language', 'lang'),
                );  
        }
        
        
        /**
         * Load Object that has been published and time is <= time()
         * @param type $id
         * @return type 
         */
        public static function loadPublishedModel($id){
		$model=Object::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else {
			if(($model->object_status==ConstantDefine::OBJECT_STATUS_PUBLISHED) && ($model->object_date <= time())){
				return $model;
			} else {
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
	}
        
        /**
         * Save Meta Data of a Object Content Type
         * @param type $key
         * @param type $value
         * @param type $object
         * @param type $create 
         */
        public static function saveMetaValue($key,$value,$object,$create=true){
            if($create){
                $object_meta = new ObjectMeta;
                $object_meta->meta_key=$key;
                $object_meta->meta_value=$value;
                $object_meta->meta_object_id=$object->object_id;                      
                $object_meta->save();
            } else {
                $object_meta = ObjectMeta::model()->find('meta_key= :key  and meta_object_id = :obj ',
                                                     array(':key'=>$key,':obj'=>$object->object_id));
                if($object_meta!=null){
                        $object_meta->meta_value=$value;
                        $object_meta->save();
                } else {
                    $object_meta = new ObjectMeta;
                    $object_meta->meta_key=$key;
                    $object_meta->meta_value=$value;
                    $object_meta->meta_object_id=$object->object_id;                      
                    $object_meta->save();
                }

            }
        }
        
        /**
         * Convert from value to the String of the Object Status
         * @param type $value 
         */
        public static function convertObjectStatus($value){
                $status=ConstantDefine::getObjectStatus();
                if(isset($status[$value])){
                    return $status[$value];
                } else {
                    return t('undefined');
                }
        }
        
         /**
         * Convert from value to the String of the Object Comment
         * @param type $value 
         */
        public static function convertObjectCommentType($value){
                $types= ConstantDefine::getObjectCommentStatus();                
                if(isset($types[$value])){
                    return $types[$value];
                } else {
                    return t('undefined');
                }
        }
        
        /**
         * Get the history workflow of the Object
         * @param type $object 
         */
        public static function getTransferHistory($model){
                
                $trans=Transfer::model()->with('from_user')->findAll(array(
		    'condition'=>' object_id=:obj ',
		    'params'=>array(':obj'=>$model->object_id),
		    'order'=>'transfer_id ASC'
		));
		
		$trans_list="<ul>";
		
		$trans_list.="<li>- <b>".$model->author->display_name."</b> ".t("created on")." <b>".date('m/d/Y H:i:s',$model->object_modified)."</b></li>";
		//Start to Translate all the Transition
		foreach($trans as $tr){
			if($tr->type==ConstantDefine::TRANS_STATUS){
				$temp="<li>- <b>".$tr->from_user->display_name."</b> ".t("changed status to")." <b>".self::convertObjectStatus($tr->after_status)."</b> ".t("on")." <b>".date('m/d/Y H:i:s',$tr->time)."</b></li>";
			}
			if($tr->type==ConstantDefine::TRANS_ROLE){
				$temp="<li>- <b>".$tr->from_user->display_name."</b> ".t("modified and sent to")." <b>".ucfirst($tr->note)."</b> ".t("on")." <b>".date('m/d/Y H:i:s',$tr->time)."</b></li>";
			}
			if($tr->type==ConstantDefine::TRANS_PERSON){
				$to_user=User::model()->findbyPk($tr->to_user_id);
				$name="";
				if($to_user!=null) $name=$to_user->display_name; 
				$temp="<li>- <b>".$tr->from_user->display_name."</b> ".t("modified and sent to")." <b>".ucfirst($name)."</b> ".t("on")." <b>".date('m/d/Y H:i:s',$tr->time)."</b></li>";
			}
			$trans_list.=$temp;
		}
		$trans_list.='</ul>';
                
                return $trans_list;
        }
        
        /**
         * Convert from value to the String of the Object Type
         * @param type $value 
         */
        public static function convertObjectType($value){
                $types= GxcHelpers::getAvailableContentType();                
                if(isset($types[$value]['name'])){
                    return $types[$value]['name'];
                } else {
                    return t('undefined');
                }
        }
        
        /**
         * Do Search Object based on its status
         * @param type $type
         * @return CActiveDataProvider 
         */
        public function doSearch($type=0){
		
		$criteria=new CDbCriteria;
		$sort = new CSort;
                $sort->attributes = array(
                        'object_id',
                );
                $sort->defaultOrder = 'object_id DESC';
                
                switch ($type){
                    
                    //If looking for DRAFT Content
                    case ConstantDefine::OBJECT_STATUS_DRAFT:
                        $criteria->condition='object_status = :status and object_author = :uid';
			$criteria->params=array(':status'=>  ConstantDefine::OBJECT_STATUS_DRAFT,
						':uid'=>user()->id);                        
                        break;
                    
                    //If looking for Pending Content
                    case ConstantDefine::OBJECT_STATUS_PENDING:
                        
                        $criteria->select=" t.*";
			$criteria->distinct=true;

			$current_user_roles=Rights::getAssignedRoles(user()->id,true);
			
			foreach($current_user_roles as $r){
				$user_roles_allow[]=$r->name;		
			}
			
			$criteria->join="JOIN gxc_transfer as tr ON t.object_id = tr.object_id
			LEFT OUTER JOIN gxc_transfer tr2 ON (t.object_id = tr2.object_id AND 
			(tr.time < tr2.time OR tr.time = tr2.time AND tr.transfer_id < tr2.transfer_id))";
                        
			$criteria->condition='object_status = :status and tr2.transfer_id IS NULL and
			(( tr.type= :type_person and tr.to_user_id = :toperson ) or (
			   tr.type= :type_role and tr.note in ( "'. implode(",",$user_roles_allow) .'" )
			) )
			';
			
			$criteria->params=array(':status'=>  ConstantDefine::OBJECT_STATUS_PENDING,':toperson'=>user()->id,
						':type_person'=>  ConstantDefine::TRANS_PERSON,
						':type_role'=>  ConstantDefine::TRANS_ROLE);
                        break;
                        
                     //If looking for Published Content
                    case ConstantDefine::OBJECT_STATUS_PUBLISHED:
                        
                        //Do nothing;
			$criteria->condition='object_status = :status';
			$criteria->params=array(':status'=>  ConstantDefine::OBJECT_STATUS_PUBLISHED);
                        break;
                }

		
		
		
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('object_author',$this->object_author,true);
		$criteria->compare('object_date',$this->object_date);
		$criteria->compare('object_content',$this->object_content,true);
		$criteria->compare('object_title',$this->object_title,true);
		$criteria->compare('object_name',$this->object_name,true);
		
                
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public static function buildLink($obj){						
		if($obj->object_id)
			return FRONT_SITE_URL."/article?id=".$obj->object_id."&slug=".$obj->object_slug;
		else 
			return null;
	}
	
	public function getObjectLink(){						
		if($this->object_id){
			$class_name=GxcHelpers::getClassOfContent($this->object_type);
			if($class_name!='Object'){
				 Yii::import('common.content_type.'.$this->object_type.'.'.$class_name);
				 				
			}
			return $class_name::buildLink($this);
		} else {
			return null;
		}
	}

	    
	public function suggestContent($keyword,$type='',$limit=20)
	{
		if($type==''){
			$objects=$this->findAll(array(
			'condition'=>'object_name LIKE :keyword',
			'order'=>'object_id DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		} else {
			$objects=$this->findAll(array(
			'condition'=>'object_type = :t and object_name LIKE :keyword',
			'order'=>'object_name DESC',
			'limit'=>$limit,
			'params'=>array(
				':t'=>trim(strtolower($type)),
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
			));
		}
		$names=array();
		foreach($objects as $object)
			$names[]=str_replace(";","",$object->object_name)."|".$object->object_id;
		return $names;
	}
        
        public static function Resources(){
            return array(
              'thumbnail'=>array('type'=>'thumbnail',
              'name'=>'Thumbnail',
              'maxSize'=>ConstantDefine::UPLOAD_MAX_SIZE, 
              'minSize'=>ConstantDefine::UPLOAD_MIN_SIZE,
              'max'=>1,
              'allow'=>array('jpeg',
                             'jpg',
                             'gif',
                             'png'))) ; 
        }
        
        
        public static function Permissions(){
            return array(
                ConstantDefine::USER_GROUP_ADMIN=>array(
                    'allowedObjectStatus'=>array(
                                           ConstantDefine::OBJECT_STATUS_DRAFT=>array('condition'=>''),
                                           ConstantDefine::OBJECT_STATUS_PENDING=>array('condition'=>''),
                                           ConstantDefine::OBJECT_STATUS_PUBLISHED=>array('condition'=>''),
                                           ConstantDefine::OBJECT_STATUS_HIDDEN=>array('condition'=>''),
                                           ),
                    'allowedTransferto'=>array(
                                           ConstantDefine::USER_GROUP_EDITOR=>array('condition'=>''),
                                           ConstantDefine::USER_GROUP_REPORTER=>array('condition'=>''),                                           
                                           ), 
                    
                    'allowedToCreateContent'=>true,
                    
                    'allowedToUpdateContent'=>''
                ),
                ConstantDefine::USER_GROUP_EDITOR=>array(
                    'allowedObjectStatus'=>array(
                                           ConstantDefine::OBJECT_STATUS_DRAFT=>array('condition'=>'return $params["new_content"]==true;'),
                                           ConstantDefine::OBJECT_STATUS_PENDING=>array('condition'=>''),
                                           ConstantDefine::OBJECT_STATUS_PUBLISHED=>array('condition'=>''),
                                           ConstantDefine::OBJECT_STATUS_HIDDEN=>array('condition'=>'return $params["new_content"]==false;'),
                                           ),
                    'allowedTransferto'=>array(
                                           ConstantDefine::USER_GROUP_EDITOR=>array('condition'=>''),
                                           ConstantDefine::USER_GROUP_REPORTER=>array('condition'=>''),                                          
                                           ),

                    'allowedToCreateContent'=>true,
                    
                    'allowedToUpdateContent'=>'
                                        return (($params["new_content"]==false)&&
                                        (($params["content_status"]==ConstantDefine::OBJECT_STATUS_PUBLISHED)
                                        ||(($params["content_status"]==ConstantDefine::OBJECT_STATUS_DRAFT)&&($params["content_author"]==user()->id))
                                        ||(($params["content_status"]==ConstantDefine::OBJECT_STATUS_PENDING)&&($params["trans_to"]==user()->id))
                                        ||(($params["content_status"]==ConstantDefine::OBJECT_STATUS_PENDING)&&($params["trans_type"]==ConstantDefine::TRANS_ROLE)&&(array_key_exists($params["trans_note"],Rights::getAssignedRoles(user()->id,true))))
                                        ));'
                ),
                ConstantDefine::USER_GROUP_REPORTER=>array(
                           'allowedObjectStatus'=>array(
                                                  ConstantDefine::OBJECT_STATUS_DRAFT=>array('condition'=>
                                                    'return
                                                           ($params["new_content"]==true) ;        
                                                           '),
                                                  ConstantDefine::OBJECT_STATUS_PENDING=>array('condition'=>
                                                    'return
                                                           ((($params["new_content"]==false)&&($params["content_status"]!=ConstantDefine::OBJECT_STATUS_PUBLISHED)&&(($params["trans_to"]==user()->id)||($params["trans_to"]==0)))||
                                                
                                                           ($params["new_content"]==true)) ;        
                                                           '),
                                                  ConstantDefine::OBJECT_STATUS_HIDDEN=>array('condition'=>
                                                 'return
                                                          (($params["new_content"]==false)&&($params["content_status"]==ConstantDefine::OBJECT_STATUS_DRAFT)&&($params["content_author"]==user()->id)) ;
                                                          '),
                                                  ),
                                                 
                           'allowedTransferto'=>array(
                                                  ConstantDefine::USER_GROUP_EDITOR=>array('condition'=>''),
                                                  ConstantDefine::USER_GROUP_REPORTER=>array('condition'=>''), 
                                                  ),
                            'allowedToCreateContent'=>true,
                    
                            'allowedToUpdateContent'=>'
                                        return (($params["new_content"]==false)&&
                                        ((($params["content_status"]==ConstantDefine::OBJECT_STATUS_DRAFT)&&($params["content_author"]==user()->id))
                                        ||(($params["content_status"]==ConstantDefine::OBJECT_STATUS_PENDING)&&($params["trans_to"]==user()->id))
                                        ||(($params["content_status"]==ConstantDefine::OBJECT_STATUS_PENDING)&&($params["trans_type"]==ConstantDefine::TRANS_ROLE)&&(array_key_exists($params["trans_note"],Rights::getAssignedRoles(user()->id,true))))
                                        )) ;'
                       )  
            );
        }
}