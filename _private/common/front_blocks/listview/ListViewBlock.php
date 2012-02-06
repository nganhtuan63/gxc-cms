<?php

/**
 * Class for render Content based on Content list
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.html
 */

class ListViewBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='listview';
    public $block=null;    
    public $errors=array();
    public $page=null;
    public $layout_asset='';
    
    //Content list attribute
    public $content_list;    
    
    
    
    public function setParams($params){
	    $this->content_list=isset($params['content_list']) ? $params['content_list'] : array();
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
	return true;
    }
    
    public function params()
    {
            return array(
                    'content_list' => t('Content list'),                   
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