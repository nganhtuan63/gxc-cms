<?php

/**
 * This is the Widget for manage a specific Model.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets
 *
 */
class ModelManageWidget extends CWidget
{
    
    public $visible=true; 
    public $model_name=''; 
 
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
        $model_name=$this->model_name;
        if($model_name!=''){
            
            $model=new $model_name('search');            
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET[$model_name]))
                    $model->attributes=$_GET[$model_name];                       
             $this->render(strtolower($model_name).'/'.strtolower($model_name).'_manage_widget',array('model'=>$model));
        } else {
            throw new CHttpException(404,t('The requested page does not exist.'));
        }
    }   
}
