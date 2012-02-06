<?php

/**
 * Class for render Sign in Box
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.signin
 */

class SigninBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='signin';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {        
            $this->renderContent();
    }       
 
 
    protected function renderContent()
    {
        
      
	if(isset($this->block) && ($this->block!=null)){
            
                $model=new UserLoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
                   
		// collect user input data
		if(isset($_POST['UserLoginForm']))
		{
                       
			$model->attributes=$_POST['UserLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				Yii::app()->controller->redirect(bu().'/dashboard');
		}              
            $this->render(BlockRenderWidget::setRenderOutput($this),array('model'=>$model));
	} else {
	    echo '';
	}
       
    }
    
    public function validate(){	
		return true ;
    }
    
    public function params()
    {
         return array();
    }
    
    public function beforeBlockSave(){
	return true;
    }
    
    public function afterBlockSave(){
	return true;
    }
}

?>