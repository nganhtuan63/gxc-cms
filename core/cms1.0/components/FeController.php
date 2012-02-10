<?php

/**
 * Class of parent Controller for Front end of GXC CMS, extends from RController
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.components
 */

class FeController extends RController
{	
        
        public function __construct($id,$module=null)
		{
			 parent::__construct($id,$module);		 
	                 if(isset($_POST)){
	                     $_POST = fn_clean_input($_POST);
	                 }
	                 if(isset($_GET)){
	                     $_GET = fn_clean_input($_GET);
	                 }
		}
        
        /**
         * Filter by using Modules Rights
         * 
         * @return type 
         */
        public function filters()
        {
               return array(
                   'rights',
               );
        }
           
        /**
         * List of allowd default Actions for the user
         * @return type 
         */
        public function allowedActions()
        {
               return 'login,logout';
        }
               
        
        public function renderPageSlug($slug){
            $slug=fn_clean_input($slug);
            $page = Page::model()->find(array(
                'condition'=>'slug=:paramId',
                'params'=>array(':paramId'=>$slug))); 								
            if($page){
                $this->layout='main';	    
                //depend on the layout of the page, use the corresponding file to render                
                    $this->render('common.front_layouts.'.$page->layout.'.'.$page->display_type,array('page'=>$page));                                
            } else {            	  
                  throw new CHttpException('404',t('Oops! Page not found!'));
            }
        }
        
        public function error(){
            if($error=Yii::app()->errorHandler->error)
		    {
		    	if(Yii::app()->request->isAjaxRequest)
		    		echo $error['message'];
		    	else
		        	$this->renderPageSlug('error');
		    }
        }
       

}