<?php
/**
 * Backend Osg Brand Page Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class ObbrandpageController extends BeController{
           
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
               
		 
	}
        
        public function actionCreate(){
                $model=new BrandPage ;                       
                
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
                Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
                
		if(isset($_POST['BrandPage']))
		{          
                        $model->attributes=$_POST['BrandPage'];              
                        if ($model->save()) {          
                            user()->setFlash('success',t('Create new Brand Page Successfully!'));                                                                                       
                            
                             if(!isset($_GET['embed'])) {
                                 $model=new BrandPage;
                                 $this->redirect(array('create'));                                   
                             }
                        }                
                    
                }      
                $this->render('_form',array(
			'model'=>$model			
		));     
        }
        
        public function actionUpdate($id){
                $model=GxcHelpers::loadDetailModel('BrandPage', $id); 
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
                Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
                
		if(isset($_POST['BrandPage']))
		{          
                        $model->attributes=$_POST['BrandPage'];              
                        if ($model->save()) {          
                            user()->setFlash('success',t('Update Brand Page Successfully!'));                                                                                                                    
                        }                
                    
                }      
                $this->render('_form',array(
			'model'=>$model			
		));
        }
        
      
        public function actionDelete(){
            
            $id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if(Yii::app()->request->isPostRequest){                
                    //First make sure that there is no children category
                    $model=GxcHelpers::loadDetailModel('BrandPage', $id);                                      
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
        
        public function actionchangeOrder(){
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
                            $command->update('gxc_osg_brand_page', array(
                                'order'=>$order+1,
                            ),  'bp_id=:id', array(':id'=>$id));

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
        
        /**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='brandpage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
          /**
         * Suggests name based on the current user input.
         * This is called via AJAX when the user is entering the tags input.
         */
        public function actionSuggestName()
        {
            if( isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
            {
                //First we get the Parent and Check the term of the Brand Page Parent                
                $brand_page_parent=isset($_GET['parent']) ? (int)$_GET['parent'] : 0;
                
                $parent_id=0;
                
                $limit=10;
                
                $parent=BrandPage::model()->findByPk($brand_page_parent);
                //Get the parent term
                if($parent){
                    $parent_id=$parent->bp_term_id;
                }
                                
                $terms=Term::model()->findAll(array(
                'condition'=>'name LIKE :keyword and parent=:parent_id',
                'order'=>'term_id DESC',
                'limit'=>$limit,
                'params'=>array(
                    ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                    ':parent_id'=>$parent_id)
                ));        

                $names=array();
                foreach($terms as $term)
                    $names[]=str_replace(";","",$term->name)."|".$term->term_id;            
                if($names!==array())
                    echo implode("\n",$names);
            }
        }
        
    

        
        
        
}