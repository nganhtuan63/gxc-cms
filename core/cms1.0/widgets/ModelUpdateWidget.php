<?php

/**
 * This is the Widget for Updating Model Information.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets
 *
 */
class ModelUpdateWidget extends CWidget
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
        $model_id=isset($_GET['id']) ? (int)$_GET['id'] : 0;        
        if($model_id!==0) {
            
            $model_name=$this->model_name;
            if($model_name!=''){
                $model=$model_name::model()->findbyPk($model_id);               
                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']===strtolower($model_name).'update-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }    
                // collect user input data
                if(isset($_POST[$model_name]))
                {                      
                        if($model->save()){
                            user()->setFlash('success',t('Updated Successfully!'));                                        
                        }			

                }

                $this->render(strtolower($model_name).'/'.strtolower($model_name).'_update_widget',array('model'=>$model));            
            } else {
                throw new CHttpException(404,t('The requested page does not exist.'));
            }
            
        } else {
            throw new CHttpException(404,t('The requested page does not exist.'));
        }

    }   
}
