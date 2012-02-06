<?php

/**
 * Class for render Iframe Box
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.iframe
 */

class IframeBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='iframe';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
	public $data;
    
    
    
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
        $this->render(BlockRenderWidget::setRenderOutput($this),array('data'=>$this->data));				      
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