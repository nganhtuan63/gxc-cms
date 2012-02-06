<?php

/**
 * This is the Widget for Updating a Content List
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class ContentListUpdateWidget extends CWidget
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
            $content_list_id=isset($_GET['id']) ? (int)$_GET['id'] : 0;     
            $model=GxcHelpers::loadDetailModel('ContentList', $content_list_id); 
            
            
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
                                user()->setFlash('success',t('Update Content list Successfully!'));                                                                
                            }
                        }
                   }
            }
                        
            Yii::app()->controller->layout=isset($_GET['embed']) ? 'clean' : 'main';
            $this->render('cmswidgets.views.contentlist.contentlist_form_widget',array('model'=>$model));            
    }   
    
    
}
