<?php

/**
 * This is the Widget for Updating a Menu Item
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class MenuItemUpdateWidget extends CWidget
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
            $term_id=isset($_GET['id']) ? (int)$_GET['id'] : 0;     
            $model=GxcHelpers::loadDetailModel('MenuItem', $term_id);                
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='menuitem-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
            // collect user input data
            if(isset($_POST['MenuItem']))
            {
                    $model->attributes=$_POST['MenuItem'];                        
                    if($model->save()){                            
                        user()->setFlash('success',t('Update Menu Item Successfully!'));                                                                
                    }
            }
            Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
            $this->render('cmswidgets.views.menuitem.menuitem_form_widget',array('model'=>$model));                                
    }   
    
    
}
