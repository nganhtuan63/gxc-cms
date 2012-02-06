<?php
/**
 * Backend Osg Fetch Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class ObfetchController extends BeController{
           
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);                		 
	}
        
        public function actionCreate(){
                $model=new ProductFetch;                       
                
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
                Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
                
		if(isset($_POST['ProductFetch']))
		{          
                        $model->attributes=$_POST['ProductFetch'];              
                        if ($model->save()) {          
                            user()->setFlash('success',t('Create new Fetch Successfully!'));                                                            
                            
                             if(!isset($_GET['embed'])) {
                                 $model=new Term;
                                 $this->redirect(array('create'));                                   
                             }
                        }                
                    
                }      
                $this->render('_form',array(
			'model'=>$model			
		));     
        }
        
        public function actionUpdate($id){
                $model=GxcHelpers::loadDetailModel('ProductFetch', $id); 
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
                Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
                
		if(isset($_POST['ProductFetch']))
		{          
                        $model->attributes=$_POST['ProductFetch'];              
                        if ($model->save()) {          
                            user()->setFlash('success',t('Update Fetch Successfully!'));                                                                                                                    
                        }                
                    
                }      
                $this->render('_form',array(
			'model'=>$model			
		));
        }
        
        public function actionAdmin(){
            
        }
        
        public function actionDelete(){
            
            $id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if(Yii::app()->request->isPostRequest){                
                    //First make sure that there is no children category
                    $model=GxcHelpers::loadDetailModel('ProductFetch', $id);                                      
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
        
        /**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fetch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
      

        
        
        public function actionTest(){
            
            $id= isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $params=array();
            $params['site_url']='';
            $params['page_url']='';
            $params['current_page']=1;
            $params['brand']='';
          
            $result='';
            
            $modelProductFetch = new ProductFetch;
            
            if($id!=0){
                        $fetch_params=ProductFetch::model()->findbyPk($id);        
                        //If found the Fetch Params
                        if($fetch_params){
                            $params['product_wrapper']= $fetch_params->pf_wrapper;
                            /*$params['product_link']=$fetch_params->pf_link;
                            $params['product_name']=$fetch_params->pf_name;
                            $params['product_image']=$fetch_params->pf_image;    
                            $params['product_regular_price']=$fetch_params->pf_regular_price;    
                            $params['product_sale_price']=$fetch_params->pf_sale_price;
                            
                            $params['product_detail_price']=$fetch_params->pf_detail_price; //To check price is still valid or not
                            */
                            $params['product_template'] = $fetch_params->pf_template;        
                            $params['product_brand']=$fetch_params->pf_brand;    
                            $params['paging_wrap']=$fetch_params->pf_paging_wrap;
                            $params['onsite_id']=$fetch_params->pf_onsite_product_id;
                            
                            
                            $modelProductFetch=$fetch_params;
                            
                            //Try to get the Brand id of the current Fetch
                            $brand_page=BrandPage::model()->with('brand_parent')->find('bp_fetch_id = :fid',array(':fid'=>$fetch_params->pf_id));
                            if($brand_page){
                                $params['site_url']=$brand_page->brand_parent->brand_site;
                                $params['page_url']=$brand_page->bp_url;
                                $params['brand']=$brand_page->brand_parent->brand_name;
                            }
                            
                        }
                
            }
            
            if( isset($_POST['ProductFetch']) && /*isset($_POST['site_url']) &&*/ isset($_POST['page_url']) ){
                        $fetch_params = new ProductFetch;
                        $fetch_params->attributes =   $_POST['ProductFetch'];
                        $fetch_params->pf_paging_wrap = $_POST['ProductFetch']['pf_paging_wrap'];
                                   
            
                        $params['product_wrapper']= $fetch_params->pf_wrapper;
                        $params['page_url']=trim($_POST['page_url']); 
                        $params['product_template']=$fetch_params->pf_template;                        
                        /*$params['product_link']=$fetch_params->pf_link;
                        $params['product_name']=$fetch_params->pf_name;
                        $params['product_image']=$fetch_params->pf_image;    
                        $params['product_regular_price']=$fetch_params->pf_regular_price;    
                        $params['product_sale_price']=$fetch_params->pf_sale_price;
                        
                        $params['product_detail_price']=$fetch_params->pf_detail_price; //To check price is still valid or not
                        $params['product_brand']=$fetch_params->pf_brand;    
                                              
                        */
                        $params['site_url']=$params['site']=trim($_POST['site_url']);
                        $params['current_page']=trim($_POST['current_page']);
                        $params['brand']=trim($_POST['brand']);
                        $params['onsite_id']=$fetch_params->pf_onsite_product_id;
                        $params['paging_wrap']= $fetch_params->pf_paging_wrap;
                        
                        $modelProductFetch = $fetch_params;
                        
                        $continue=true;
                            
                        if($params['page_url']==''){
                            $fetch_params->addError('','Need to fill blank for Page url');
                            $continue=false;
                        }
                        if($params['product_wrapper']==''){
                            $fetch_params->addError('','Need to fill blank for Product Wrapper');
                            $continue=false;
                        }
                        if($params['product_template']==''){
                            $fetch_params->addError('','Need to fill blank for Product Name');
                            $continue=false;
                        }
                        
                        if($continue){
                                $file_after_fetch=Crawl::crawlTestFetch($params);
                               //$file_after_fetch='/Applications/MAMP/htdocs/osg/tmp//4e292e70e92d9';
                                if($file_after_fetch){
                                    //Continue to Fetch the Data
                                    $result=Parse::parseTestFetch($file_after_fetch,$params);
                                    if(file_exists($file_after_fetch)){
                                       @unlink($file_after_fetch);
                                    }
                                } else {
                                    $fetch_params->addError('','Fail to Crawl the Page');
                                }                            
                        }
            }
                                        
            
            $this->render('test',array(
               'modelProductFetch'=>$modelProductFetch,
               'params'=>$params,
               'result'=>$result
        ));
            
            
        }
        
        
        
}