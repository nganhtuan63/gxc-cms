<?php

/**
 * This is the Widget for Rendering Tree for Hierachy Data Submit
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets
 *
 */
class TreeFormWidget extends CWidget
{
    
    public $visible=true; 
    public $title='';
    public $item_template='';
    
    public $form_create_url='';
    public $form_update_url='';
    public $form_change_order_url='';
    public $form_delete_url='';
    
    
    
   
    public $list_items=array();
    
 
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
        
        $this->render('tree/tree_form',array());                        
        
    }   
}
