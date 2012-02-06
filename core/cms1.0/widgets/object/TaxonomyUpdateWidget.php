<?php

/**
 * This is the Widget for Updating Taxonomy
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 */
class TaxonomyUpdateWidget extends CWidget
{
    
    public $visible=true; 
    
    public $form_create_term_url='';
    public $form_update_term_url='';
    public $form_change_order_term_url='';
    public $form_delete_term_url='';
 
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
        $id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model=  GxcHelpers::loadDetailModel('Taxonomy', $id);
            
        
        //The type of the content we want to create
        $type=$model->type;
        
        //Guid of the Object
        $guid=$model->guid;                            
        
        //List of language that should exclude not to translate       
        $lang_exclude=array();
        
        //List of translated versions
        $versions=array();        
     
        $list_items=array();
        
        //Look for the Term Items belong to this Taxonomy
        $list_terms=Term::model()->findAll(
                 array(
                     'select'=>'*',
                     'condition'=>'taxonomy_id=:id',
                     'order'=>'t.parent ASC, t.order ASC, t.term_id ASC',
                     'params'=>array(':id'=>$id)
                 ));
        if($list_terms){
            foreach($list_terms as $term) {                
                $temp_item['id']=$term->term_id;
                $temp_item['name']=CHtml::encode($term->name);
                $temp_item['parent']=$term->parent;
                
                //Add Item here to make sure Chrome not change the order of Json Object
                $list_items['item_'.$term->term_id]=$temp_item;
            }
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
                    user()->setFlash('success',t('Update Taxonomy Successfully!'));                                                           
                }
        }

        $this->render('cmswidgets.views.taxonomy.taxonomy_form_widget',array('model'=>$model,'lang_exclude'=>$lang_exclude,'versions'=>$versions,'type'=>$type,
            'list_items'=>$list_items
            ));            
        
        
          
    }   
}
