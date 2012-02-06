<?php

/**
 * This is the Widget for Creating new Term
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 *
 */
class TermCreateWidget extends CWidget
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
        $model = new Term;                
                
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='term-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['Term']))
        {
                $model->attributes=$_POST['Term'];                        
                if($model->save()){                            
                    user()->setFlash('success',t('Create new Term Successfully!'));   
                    
                    if(!isset($_GET['embed'])) {
                        $model=new Term;
                        Yii::app()->controller->redirect(array('create'));  
                    }
                }
        }
        
        Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
        $this->render('cmswidgets.views.term.term_form_widget',array('model'=>$model));                        
        
    }   
    
    
}
