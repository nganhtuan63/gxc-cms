<?php

/**
 * This is the Widget for Updating a Page 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.page
 *
 */
class PageUpdateWidget extends CWidget
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
        $id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model=  GxcHelpers::loadDetailModel('Page', $id);
            
      
        //Guid of the Object
        $guid=$model->guid;                            
        
        //List of language that should exclude not to translate       
        $lang_exclude=array();
        
        //List of translated versions
        $versions=array();                             
         

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
        
        //Define Blocks in Regions
        $regions_blocks=array();
        
        //Find all the Page Blocks of this current Page
        $page_blocks=PageBlock::model()->findAll(
                array(
                    'condition'=>'page_id = :pid',
                    'params'=>array(':pid'=>$model->page_id),
                    'order'=>'region ASC, block_order ASC'
                )
                );
        
        foreach($page_blocks as $pb){
            $regions_blocks[$pb->region]['id'][]=$pb->block_id;
            $regions_blocks[$pb->region]['status'][]=$pb->status;
        }
        
        
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
                    user()->setFlash('success',t('Update Page Successfully!'));                                                                               
                }
        }                
        $this->render('cmswidgets.views.page.page_form_widget',array('model'=>$model,'lang_exclude'=>$lang_exclude,'versions'=>$versions,'regions_blocks'=>$regions_blocks));            

        
        
            
        
    }   
}
