<?php

/**
 * Class for render User Dashboard
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.dashboard
 */

class DashboardBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='dashboard';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {       
            if(!user()->isGuest){ 
                    $this->renderContent();
              } else {
                 user()->setFlash('error',t('Bạn cần đăng nhập để sử dụng chức năng này!'));                                                       
                Yii::app()->controller->redirect(bu().'/sign-in');
            }
    }       
 
 
    protected function renderContent()
    {     
               
        
            if(isset($this->block) && ($this->block!=null)){	              
            $this->render(BlockRenderWidget::setRenderOutput($this),array());
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