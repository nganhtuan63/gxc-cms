<?php

/**
 * This is the Widget for Creating new Block
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 *
 */
class BlockCreateWidget extends CWidget
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
        $model = new Block;  
        $block_model = null;
        
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='block-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }        
        
        $current_type=isset($_GET['type']) ? trim($_GET['type']) : '0';                
        Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
        if($current_type!='0'){        			$block_ini=parse_ini_file(Yii::getPathOfAlias('common.front_blocks.'.$current_type).DIRECTORY_SEPARATOR.'info.ini');            
            //Include the class            
		   	Yii::import('common.front_blocks.'.$current_type.'.'.$block_ini['class']);
            
			$model->type=$current_type;
					
			
            $block_model=new $block_ini['class']();                        
            
            // collect user input data
            if(isset($_POST['Block']))
            {
                    $model->attributes=$_POST['Block'];        
                    $model->type=$_POST['Block']['type'];                    
                    $params=$block_model->params();
                    $block_params=array();
                    foreach($params as $key=>$param){
                        $block_params[$key]=$block_model->$key=isset($_POST['Block'][$key]) ? $_POST['Block'][$key] : null;
                        
                    }                    
                    if($model->validate()){
                         if(!$block_model->validate()){
                             foreach($block_model->errors as $key=>$message){
                                 $model->addError($key,$message);
                             }                             
                         } else {                                
                                                               
                                $model->params=serialize($block_params);
                                $block_model->beforeBlockSave();
                                if($model->save()){
                                        $block_model->afterBlockSave();
                                        user()->setFlash('success',t('Create new Block Successfully!'));                                                                                                                                                 
                                        if(!isset($_GET['embed'])) {
                                             $model=new Block;
                                             $block_model=new $block_ini['class']();  
                                             Yii::app()->controller->redirect(array('create'),array('type'=>$current_type));  
                                        }
                                }
                         }
                    }
                   
                   
            }                        
            $this->render('cmswidgets.views.block.block_form_widget',array('model'=>$model,'type'=>$current_type,'block_model'=>$block_model));   
        }
            
        else {
            $this->render('cmswidgets.views.block.block_start_widget',array('model'=>$model,'type'=>$current_type));
	}
       
                             
        
    }   
    
    
}
