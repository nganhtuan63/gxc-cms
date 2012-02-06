<?php

/**
 * This is the model class for table "{{term}}".
 *
 * The followings are the available columns in table '{{term}}':
 * @property string $term_id
 * @property string $taxonomy_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $parent
 * @property integer $lang
 * @property integer $status
 */
class Term extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Term the static model class
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
		return '{{term}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,slug', 'required'),		
                        //Slug must be uniqued
                        array('slug', 'unique',
                        'attributeName'=>'slug',
                        'className'=>'cms.models.object.Term',
                        'message'=>t('Slug must be uniqued.'),
                        ),
			array('taxonomy_id, parent', 'length', 'max'=>20),
			array('name, slug', 'length', 'max'=>255),
                        array('description','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_id, taxonomy_id, name, description, slug, parent', 'safe', 'on'=>'search'),
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
                    'taxonomy' => array(self::BELONGS_TO, 'Taxonomy', 'taxonomy_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'term_id' => t('Term id'),
			'taxonomy_id' => t('Taxonomy id'),
			'name' => t('Name'),
			'description' => t('Description'),
			'slug' => t('Slug'),
			'parent' => t('Parent'),
                        'order' => t('Order'),
			
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

		$criteria->compare('term_id',$this->term_id,true);
		$criteria->compare('taxonomy_id',$this->taxonomy_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('parent',$this->parent,true);
	
                $sort = new CSort;
                $sort->attributes = array(
                        'term_id',
                );
                $sort->defaultOrder = 'term_id DESC';
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort
		));
	}
        
        protected function beforeSave(){
            if(parent::beforeSave())
            {
                    if($this->isNewRecord)
                    {				
                            // If this is the new Term, we will find the Max Value of Order of 
                            // the Term in the same Taxonomy
                            $this->order=
                            $command=$this->dbConnection
                            ->createCommand("SELECT MAX(`order`)+1 FROM gxc_term where taxonomy_id = :tid and parent = :pid ")
                                    ->bindValue(':tid',$this->taxonomy_id,PDO::PARAM_STR)
                                    ->bindValue(':pid',$this->parent,PDO::PARAM_STR)
                                    ->queryScalar();
                            
                    }
                    return true;
            }
            else
                    return false;
        }
        
        protected function beforeDelete(){
            
            // If this is the category : Uncategory - we won't delete it 
            
            if($this->term_id==1){
                Yii::app()->controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                return false;
            } else {
                // If this category is not empty, first move all of its content to Uncategory 
                ObjectTerm::model()->updateAll(array('term_id'=>1),'term_id = :current_id',array(':current_id'=>$this->term_id));
                return true;
            }
            
        }
        
        public static function getTermFromTaxonomy($taxonomy_id,$render=true){
                        
                $terms=Term::model()->findAll('taxonomy_id = :id',array(':id'=>$taxonomy_id));                
                $data=array(0=>t("None"));                
                if($terms && count($terms) > 0 ){
                    $data=CMap::mergeArray($data,CHtml::listData($terms,'term_id','name'));   
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
                    $model=GxcHelpers::loadDetailModel('Term', $id);                    
                    $model_childs=Term::model()->find('parent = :parent_id',array(':parent_id'=>$model->term_id));                    
                    if(!$model_childs){
                        $model->delete();
                        echo json_encode(array('result'=>t('success'),'message'=>''));
                    } else {
                        echo json_encode(array('result'=>t('error'),'message'=>t('Error! Please delete its children first!')));
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
                            
                            $command->update('gxc_term', array(
                                'order'=>$order+1,
                            ), 'term_id=:id', array(':id'=>$id));

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
        
        
        public static function getTermName($id){
            $term=Term::model()->findByPk($id);
            if($term){
                return $term->name;
            }            
            return '';
        }
        
       
}