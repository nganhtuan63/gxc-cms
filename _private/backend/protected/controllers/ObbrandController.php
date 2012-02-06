<?php
/**
 * Backend Osg Brand Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class ObbrandController extends BeController{
    
        public $defaultAction='admin';
       
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Brand'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Add Brand'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
       
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                
               $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Brand'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Brand'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                );
              
		$model=$this->loadModel($id);
		
		//Find Brand Page of the Current Band with diffrent Fetch Id
		$brand_fetchs= ProductFetch::model()->findAll(
			array(			
			'condition'=>'pf_brand_id = :bid',
			'params'=>array(':bid'=>$id)));
		
		$this->render('view',array(
			'model'=>$model,
			'brand_fetchs'=>$brand_fetchs
		));
	}
	
        /**
         * Change the time that the Brand should be revisited
         */
	public function actionChangeRevisit(){
		$brand_id=isset($_POST['brand_id']) ? (int)$_POST['brand_id'] : 0;
		$next_value=isset($_POST['next_value']) ? (int)$_POST['next_value'] : 0;
		if(($brand_id==0) || ($next_value==0)){
			echo '0';
			exit;
		} else {
			$brand=Brand::model()->findByPk($brand_id);
			if($brand){
				$brand->brand_revisit=$next_value;
				$brand->save();
				echo '1';
				exit;
			} else {
				echo '0';
				exit;
			}
		}
	}
	
        /*
         * Change the Brand Image Logo
         */
	public function actionChangeImage(){
		$brand_id=isset($_POST['brand_id']) ? (int)$_POST['brand_id'] : 0;
		$next_value=isset($_POST['next_value']) ? trim($_POST['next_value']) : '';
		if(($brand_id==0) || ($next_value=='')){
			echo '0';
			exit;
		} else {
			$brand=Brand::model()->findByPk($brand_id);
			if($brand){
				$brand->image=$next_value;
				$brand->save();
				echo Brand::getBrandImage($brand,true);
				exit;
			} else {
				echo '0';
				exit;
			}
		}
	}
	
        /**
         * Change Brand allow Parse or Not
         */
	public function actionChangeBrandParse(){
		$brand_id=isset($_POST['brand_id']) ? (int)$_POST['brand_id'] : 0;
		$next_value=isset($_POST['next_value']) ? trim($_POST['next_value']) : '';
		if(($brand_id==0) || ($next_value=='')){
			echo '0';
			exit;
		} else {
			$brand=Brand::model()->findByPk($brand_id);
			if($brand){
				$brand->brand_for_parse=$next_value;
				$brand->save();
				echo $brand->brand_for_parse;
				exit;
			} else {
				echo '0';
				exit;
			}
		}
	}
	
	
        /**
         * Change Next Crawl time
         */
	public function actionChangeNextCrawl(){
		$brand_id=isset($_POST['brand_id']) ? (int)$_POST['brand_id'] : 0;
		if(($brand_id==0)){
			echo '0';
			exit;
		} else {
			$brand=Brand::model()->findByPk($brand_id);
			if($brand){
				$next_crawl=trim($_POST['next_value']);
				if($next_crawl=='1'){
					$brand->brand_next_crawl=time()+(2*60);
				} else {
					$brand->brand_next_crawl=strtotime($next_crawl);
				}
				$brand->save();
				echo date("Y-m-d H:i:s",$brand->brand_next_crawl);
				exit;
			} else {
				echo '0';
				exit;
			}
		}
	}
	
	

        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $model=new Brand;                
                
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
                $arr_fetch=array();
                
		if(isset($_POST['Brand']))
		{          
                        $model->attributes=$_POST['Brand'];
                        $model->brand_created=time();
                        $model->brand_updated=time();                
                        $model->brand_for_parse=$model->brand_name;
                        $model->brand_affiliate = $_POST['Brand']['brand_affiliate'];                                                
                        $current_last_crawled=time()+(2*60);
                        $next_crawled=$current_last_crawled+(60*60*24*3);
                        $model->brand_last_crawled=time()+(2*60);
                        $model->brand_next_crawl=$next_crawled;
                        
                       
                        if ($model->save()) {          
                            user()->setFlash('success',t('Create new Brand Successfully!'));                                                            
                            $this->redirect(array('create'));                                   
                        }                
                    
                }      
                $this->render('create',array(
			'model'=>$model,
                        'arr_fetch'=>$arr_fetch
		));     
	}
                
       
        
      
        /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
                
                $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Brand'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Brand'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                );
              
                $model=$this->loadModel($id);	
		 
                $list_items=array();
                
                //Look for the Brand Pages belongs to this Brand
                $list_pages=BrandPage::model()->findAll(
                         array(
                             'select'=>'*',
                             'condition'=>'bp_brand_id=:id',
                             'order'=>'t.parent ASC, t.order ASC',
                             'params'=>array(':id'=>$id)
                         ));
                if($list_pages){
                    foreach($list_pages as $page) {                
                        $temp_item['id']=$page->bp_id;
                        $temp_item['name']=$page->bp_description;
                        $temp_item['parent']=$page->parent;

                        //Add Item here to make sure Chrome not change the order of Json Object
                        $list_items['item_'.$page->bp_id]=$temp_item;
                    }
                }
                
                
                
		//Start to check some basic condition first

		if(($model->brand_allow_crawl==OsgConstantDefine::BRAND_ALLOW_CRAWL)||
		   ($model->brand_allow_parse==OsgConstantDefine::BRAND_ALLOW_PARSE)||		   
		   (Brand::getTotalCrawlQueue($model) > 0) ||
		   (Brand::getTotalParseQueue($model) > 0)
		   ){
			$this->render('update',array(
				'model'=>$model,
				'process'=>false
			));
		}
		else {
	
                      
                        //Find all Product Fetch of this Brand
                        $arr_fetch=array();
                        $fetchs=ProductFetch::model()->findAll('pf_brand_id = :bid',array(':bid'=>$model->brand_id));
                        foreach($fetchs as $fetch){
                            $arr_fetch[]=$fetch->pf_id;
                        }

			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
	
			if(isset($_POST['Brand']))
			{
				$model->attributes=$_POST['Brand'];
				$model->brand_affiliate = $_POST['Brand']['brand_affiliate'];                        
				$model->brand_for_parse=$model->brand_name;				
				  
                                if(isset($_POST['fetch_list_id'])){
                                    $arr_fetch=$_POST['fetch_list_id'];
                                }
                                
                                
				if ($model->save()) {
                                    user()->setFlash('success',t('Update Brand Successfully!'));                                                             				   
				}            
			}
	
			$this->render('update',array(
				'model'=>$model,				
				'process'=>true,
                                'arr_fetch'=>$arr_fetch,
                                'list_items'=>$list_items
			));
		}
	}

        /**
         * Change Brand Crawl State
         */
	public function actionCrawlState()
	{
		$id=(int)$_GET['id'];
		$type=(int)$_GET['type'];
		$model=$this->loadModel($id);
	                
		if($model->brand_allow_crawl!=$type)
		{
			$model->brand_allow_crawl=$type;
			$model->save();
                        
                        
		}

		$this->redirect(array('view','id'=>$model->brand_id));
		
	}
	
        /*
         * Change Parse State
         */
	public function actionParseState()
	{
		$id=(int)$_GET['id'];
		$type=(int)$_GET['type'];
		$model=$this->loadModel($id);
	

		if($model->brand_allow_parse!=$type)
		{
			$model->brand_allow_parse=$type;
			$model->save();
		}

		$this->redirect(array('view','id'=>$model->brand_id));
		
	}
	
        /**
         * Add Brand Pages To Crawl QUeue
         */
	public function actionAddCrawlQueue(){
		$id=(int)$_GET['id'];
		ParseQueue::DeleteBrandPagesQueue($id);
		CrawlQueue::AddBrandToCrawl($id);		
		$this->redirect(array('view','id'=>$id));
	}
	
        /**
         * Empty the Crawl Queue of current Brand
         * 
         */
	public function actionEmptyCrawl(){
		$id=(int)$_GET['id'];
		CrawlQueue::DeleteBrandPagesCrawl($id);
		$this->redirect(array('view','id'=>$id));
	}
	
        /**
         * Empty the Parse Queue of the current Brand
         */
	public function actionEmptyParse(){
		$id=(int)$_GET['id'];
		ParseQueue::DeleteBrandPagesQueue($id);
		$this->redirect(array('view','id'=>$id));
	}
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{       
        if(Yii::app()->request->isPostRequest)
		{
			
            $model=$this->loadModel($id)->delete();
                   
            //dump($model);
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Brand('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Brand']))
			$model->attributes=$_GET['Brand'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Manages all models.
	 */
	public function actionManageSale()
	{
		$model=new ObjectSale('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ObjectSale']))
			$model->attributes=$_GET['ObjectSale'];

		$this->render('manage_sale',array(
			'model'=>$model,
		));
	}
	
           
	/**
         * Add Brand Page to Crawl
         * @return type 
         */
	public function actionAddBrandPageCrawl(){
		//Get the Brand id from Get
		$brand_page_id = (int)$_GET['bpid'];
		return CrawlQueue::AddBrandToCrawl($brand_page_id);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Brand::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
        /**
         * Load Product Fetch of the current Brand
         * @param type $id
         * @return type 
         */
	public function loadModelProductFetch($id)
        {
		$model=ProductFetch::model()->findByPk((int)$id);
		if($model===null)
		    throw new CHttpException(404,'The requested page does not exist.');
		return $model;
        }
    
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='brand-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
	
        
        public function generateParent($page){
                
                //Get Term based on the $page
                
                $page_term=Term::model()->findByPk($page->bp_term_id);

                if($page_term->parent!=0){
                    // The current belongs to a parent Term
                    // We will need to check if the Brand Page with the Parent Term has existed or not
                    $parent_brand_page=BrandPage::model()->find('bp_brand_id = :bid and bp_term_id = :tid',
                            array(':bid'=>$page->bp_brand_id,':tid'=>$page_term->parent));
                    
                    if($parent_brand_page){
                        // If the parent page has existed
                        // We need to update the parent value for the current page
                        $page->parent=$parent_brand_page->bp_id;
                        
                        $order=
                                $command=Yii::app()->db
                                ->createCommand("SELECT MAX(`order`)+1 FROM gxc_osg_brand_page where bp_brand_id = :bid and parent = :pid ")
                                        ->bindValue(':bid',$page->bp_brand_id,PDO::PARAM_STR)
                                        ->bindValue(':pid',$page->parent,PDO::PARAM_STR)
                                        ->queryScalar();
                                
                                if(!$order) $page->order=1; else $page->order=$order;
                        
                        $page->save();
                        return false;
                        
                        echo "Found Errors - in existed Page ".print_r($page->errors).'<br />';
                    } else {
                        
                        //Get the Parent Term
                        
                        $parent_term=Term::model()->findByPk($page_term->parent);
                        // If there is no parent brand page
                        // We need to add it
                        $new_parent_brand_page=new BrandPage;
                        $new_parent_brand_page->bp_url='';
                        $new_parent_brand_page->bp_description=$parent_term->name;
                        $new_parent_brand_page->bp_term_id=$parent_term->term_id;
                        $new_parent_brand_page->parent=0;
                        $new_parent_brand_page->bp_brand_id=$page->bp_brand_id;
                        
                        $new_parent_brand_page->save();
                        
                        echo "Found Errors - in existed New Parent Brand Page 1 ".print_r($new_parent_brand_page->errors).'<br />';
                        
                        $page->parent=$new_parent_brand_page->bp_id;                        
                        $page->save();
                        
                        echo "Found Errors - in existed New Parent Brand Page 2".print_r($page->errors).'<br />';
                        //Get parent parent term
                        if($parent_term->parent!=0){
                           $result = $this->generateParent($new_parent_brand_page);
                           if ($result!==false) {
                              $new_parent_brand_page->parent = $result;
                              $new_parent_brand_page->save();
                           }
                           
                           echo "Found Errors - in existed New Parent Brand Page 3".print_r($new_parent_brand_page->errors).'<br />';
                        }     
                        
                        return $new_parent_brand_page->bp_id;
                      
                    }
                }
                
        }
        
        /*
        public function actionChangeBrandPage(){
            $pages=BrandPage::model()->findAll();
            foreach($pages as $page){
                $a=$this->generateParent($page);
            }
        }
        
         public function actionChangeBrandTerm(){
            $pages=BrandPage::model()->with('term')->findAll();
            foreach($pages as $page){
                $page->bp_description=$page->term->name;
                $page->save();
                
            }
        }
        
         * 
         */
        
        /*
         public function actionChangeBrandTerm(){
            $terms=Term::model()->findAll('term_id >= 226 and term_id <= 240');
            foreach($terms as $term){
                $description=$term->description;
               // $slug=$term->slug;
               // $slug=str_replace("accesories", "accessories", $slug);
                $description=str_replace(" Shoes ", " ", $description);
                //$slug=str_replace("--","-",$slug);
                //$description=str_replace("  "," ",$description);
                
               // $slug=$slug.'-accesories';
                //$description=trim($description.' Accesories');
                $term->description=trim($description);
                //$term->slug=trim($slug);
                $term->save();
            }
        }
         * 
         */
         
      
                    
}