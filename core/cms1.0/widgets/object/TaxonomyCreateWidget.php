<?php

/**
 * This is the Widget for Creating new Taxonomy
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 */
class TaxonomyCreateWidget extends CWidget
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
        $model = new Taxonomy;
        
        //The type of the content we want to create
        $type=isset($_GET['type']) ? strtolower(trim($_GET['type'])) : '';
        
        //If it has guid, it means this is a translated version
        $guid=isset($_GET['guid']) ? strtolower(trim($_GET['guid'])) : '';        
        
        //Get the list of Content Type
        $types=  GxcHelpers::getAvailableContentType();
        
        
        //List of language that should exclude not to translate       
        $lang_exclude=array();
        
        //List of translated versions
        $versions=array();
        
        if($type!='' && !array_key_exists($type, $types)){
            throw new CHttpException(404,t('Page Not Found'));
        } else {
                // If the guid is not empty, it means we are creating a translated version of a content
                // We will exclude the translated language and include the name of the translated content to $versions
                if($guid!=''){
                        $taxonomy_object=  Taxonomy::model()->with('language')->findAll('guid=:gid',array(':gid'=>$guid));
                        if(count($taxonomy_object)>0){
                                foreach($taxonomy_object as $obj){
                                        $lang_exclude[]=$obj->lang;
                                        $versions[]=$obj->name.' - '.$obj->language->lang_desc;
                                }
                        }
                        $model->guid=$guid;
                }

                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']==='taxonomy-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }

                // collect user input data
                if(isset($_POST['Taxonomy']))
                {
                        $model->attributes=$_POST['Taxonomy'];                        
                        if($model->save()){                            
                            user()->setFlash('success',t('Create new Taxonomy Successfully!'));                                        
                            $model=new Taxonomy;
                            
                            Yii::app()->controller->redirect(array('create'));
                        }
                }

                $this->render('cmswidgets.views.taxonomy.taxonomy_form_widget',array('model'=>$model,'lang_exclude'=>$lang_exclude,'versions'=>$versions,'type'=>$type));            

        }
        
            
        
    }   
}
