<?php

/**
 * This is the Widget for Update Resource.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets.resource
 *
 */
class ResourceUpdateWidget extends CWidget
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
                                      
        $model=new ResourceUploadForm;
 		$is_new=false;     
		$process=true;   
		$types_array=ConstantDefine::fileTypes();
		
		$id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $resource= GxcHelpers::loadDetailModel('Resource', $id);
		
		if($resource){
			$model->name=$resource->resource_name;
			$model->body=$resource->resource_body;
			$model->where=$resource->where;
			$model->type=$resource->resource_type;    
		}
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='resource-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['ResourceUploadForm']))
        {                
				$model->attributes=$_POST['ResourceUploadForm'];	
				$resource->resource_name=$model->name;															            
				$resource->resource_body=$model->body;
				$resource->resource_type=$model->type;
				if($resource->save()){
					user()->setFlash('success',t('Update Resource Successfully!'));
				}
				
        }

        $this->render('cmswidgets.views.resource.resource_form_widget',array('model'=>$model,'is_new'=>$is_new,'types_array'=>$types_array));
    }   
}
