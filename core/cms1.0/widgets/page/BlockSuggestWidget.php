<?php

/**
 * This is the Widget for Suggesting a Block for a Page
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 *
 */
class BlockSuggestWidget extends CWidget
{
    
    public $visible=true;  
    
    public function init()
    {
        
    }
 
    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }
 
    protected function renderContent()
    {       
        
        Yii::app()->controller->layout='clean';
        $this->render('cmswidgets.views.block.block_suggest_widget',array());                        
        
    }   
    
    
}
