<?php

/**
 * This is the Widget for Creating new Menu
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class MenuCreateWidget extends CWidget
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
        $model = new Menu;
                        
        //If it has guid, it means this is a translated version
        $guid=isset($_GET['guid']) ? strtolower(trim($_GET['guid'])) : '';        
                      
        
        //List of language that should exclude not to translate       
        $lang_exclude=array();
        
        //List of translated versions
        $versions=array();        
        
        // If the guid is not empty, it means we are creating a translated version of a content
        // We will exclude the translated language and include the name of the translated content to $versions
        if($guid!=''){
                $menu_object=  Menu::model()->with('language')->findAll('guid=:gid',array(':gid'=>$guid));
                if(count($menu_object)>0){
                        foreach($menu_object as $obj){
                                $lang_exclude[]=$obj->lang;
                                $versions[]=$obj->menu_name.' - '.$obj->language->lang_desc;
                        }
                }
                $model->guid=$guid;
        }

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['Menu']))
        {
                $model->attributes=$_POST['Menu'];                        
                if($model->save()){                            
                    user()->setFlash('success',t('Create new Menu Successfully!'));                                                            
                    $model=new Menu;
                    Yii::app()->controller->redirect(array('create'));
                }
        }

        $this->render('cmswidgets.views.menu.menu_form_widget',array('model'=>$model,'lang_exclude'=>$lang_exclude,'versions'=>$versions));            

        
        
            
        
    }   
}
