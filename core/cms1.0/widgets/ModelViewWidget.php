<?php

/**
 * This is the Widget for Viewing Model information.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.widgets
 *
 */
class ModelViewWidget extends CWidget
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
            $id=isset($_GET['id']) ? (int)$_GET['id'] : 0 ;       
            $model=GxcHelpers::loadDetailModel($model_name, $id);
            $this->render(strtolower($model_name).'/'.strtolower($model_name).'_view_widget',array('model'=>$model));
        } else {
            throw new CHttpException(404,t('The requested page does not exist.'));
        }
    }   
}
