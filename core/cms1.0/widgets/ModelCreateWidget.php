<?php

/**
 * This is the Widget for Creating new Model
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets
 *
 */
class ModelCreateWidget extends CWidget
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
                $model=new $model_name;
                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']===strtolower($model_name).'create-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }

                // collect user input data
                if(isset($_POST[$model_name]))
                {
                        $model->attributes=$_POST[$model_name];                        
                        if($model->save()){                            
                            user()->setFlash('success',t('Create new '.$model_name.' Successfully!'));                                        
                            $model=new $model_name;
                        }
                }
          
            $this->render(strtolower($model_name).'/'.strtolower($model_name).'_create_widget',array('model'=>$model));            
        } else {
            throw new CHttpException(404,t('The requested page does not exist.'));
        }
            
        
    }   
}
