<?php

/**
 * Class for render HTML Content Block
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.html
 */

class HtmlBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='html';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';    
    
    //HTML attribute
    public $html;    
    
    
    
    public function setParams($params){
	    $this->html=isset($params['html']) ? $params['html'] : '';
    }
    
    public function run()
    {        
            $this->renderContent();
    }       
 
 
    protected function renderContent()
    {
	if(isset($this->block) && ($this->block!=null)){	    
            //Set Params from Block Params
            $params=unserialize($this->block->params);
	    $this->setParams($params);                            
            $this->render(BlockRenderWidget::setRenderOutput($this),array());
	} else {
	    echo '';
	}
       
    }
    
    public function validate(){
	if($this->html==""){
		$this->errors['html']=t('HTML content is required');
                return false ;
	}
	else
		return true ;
    }
    
    public function params()
    {
            return array(
                    'html' => t('Html Content'),                   
            );
    }
    
    public function beforeBlockSave(){
	return true;
    }
    
    public function afterBlockSave(){
	return true;
    }
}

?>