<?php

/**
 * This is the Widget for Creating a new Content List
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class ContentListCreateWidget extends CWidget
{
    
    public $visible=true;     
    
    public $object_update_url='';
     
 
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
        $model = new ContentList;                                  
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='contentlist-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
        
        // collect user input data
        if(isset($_POST['ContentList']))
        {
                    $model->attributes=$_POST['ContentList'];                     
                    // If this is a manual list, we will add more information about the 
                    // manual list
                    if($model->type==ConstantDefine::CONTENT_LIST_TYPE_MANUAL){                                         
                        $model->manual_list=(isset($_POST['content_list_id']) && (is_array($_POST['content_list_id'])) ) ? $_POST['content_list_id'] : array();                                        
                        if(empty($model->manual_list)){                             
                            $model->addError('type',t('Please add content for manual queue'));
                        }
                    } else {
                        $model->manual_list= array();
                    }
                
               
                     if(!$model->hasErrors()){
                        if($model->validate()){
                          if($model->save()){                            
                            user()->setFlash('success',t('Create new Content list successfully!'));                                        
                             if(!isset($_GET['embed'])) {
                                    $model=new ContentList;
                                    Yii::app()->controller->redirect(array('create'));
                             }
                           
                        }
                     }
                }
             
               
        }
        
        Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
        $this->render('cmswidgets.views.contentlist.contentlist_form_widget',array('model'=>$model));            

        
        
            
        
    }   
}
