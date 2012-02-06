<?php

/**
 * This is the Widget for Creating new Page 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class PageCreateWidget extends CWidget
{
    
    public $visible=true;     
    
    public $add_existed_block_url='';
    public $add_new_block_url='';
    public $update_block_url='';
     
 
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
        $model = new Page;
                        
        //If it has guid, it means this is a translated version
        $guid=isset($_GET['guid']) ? strtolower(trim($_GET['guid'])) : '';                                      
        //List of language that should exclude not to translate       
        $lang_exclude=array();        
        //List of translated versions
        $versions=array();                
        // If the guid is not empty, it means we are creating a translated version of a content
        // We will exclude the translated language and include the name of the translated content to $versions
        if($guid!=''){
                $page_object=  Page::model()->with('language')->findAll('guid=:gid',array(':gid'=>$guid));
                if(count($page_object)>0){
                        foreach($page_object as $obj){
                                $lang_exclude[]=$obj->lang;
                                $versions[]=$obj->name.' - '.$obj->language->lang_desc;
                        }
                }
                $model->guid=$guid;
        }

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
        
        //Define Blocks in Regions
        $regions_blocks=array();
        
        
        // collect user input data
        if(isset($_POST['Page']))
        {
                $regions_blocks=isset($_POST['Page']['regions']) ? $_POST['Page']['regions'] : array();                                
                
                
                $model->attributes=$_POST['Page'];                        
                if($model->save()){           
                    
                    if(!empty($regions_blocks)){                        
                        //Delete All Page Block Before                        
                        PageBlock::model()->deleteAll('page_id = :id',array(':id'=>$model->page_id));
                        foreach($regions_blocks as $key=>$blocks){
                            $order=1;
                            for($i=0;$i<count($blocks['id']);$i++){
                                $block=$blocks['id'][$i];
                                $temp_page_block= new PageBlock;
                                $temp_page_block->page_id=$model->page_id;
                                $temp_page_block->block_id=$block;
                                $temp_page_block->region=$key;
                                $temp_page_block->block_order=$order;                                
                                $temp_page_block->status=$blocks['status'][$i];  
                                $temp_page_block->save();                                
                                $order++;
                            }
                           
                            
                        }
                    }
                    //Start to save the Page Block
                    user()->setFlash('success',t('Create new Page Successfully!'));                                                            
                    $model=new Page;
                    Yii::app()->controller->redirect(array('create'));
                }
        }                
        $this->render('cmswidgets.views.page.page_form_widget',array('model'=>$model,'lang_exclude'=>$lang_exclude,'versions'=>$versions,'regions_blocks'=>$regions_blocks));            

        
        
            
        
    }   
}
