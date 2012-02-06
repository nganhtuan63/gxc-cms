<?php
/**
 * Backend Content list Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class BecontentlistController extends BeController{
    
       
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Content List'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Create new Content List'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
                 
        /**
	 * The function that do Create new Content list
	 * 
	 */
	public function actionCreate()
	{                
		$this->render('content_list_create');
	}
        
       
        
        /**
	 * The function that do Manage Content list
	 * 
	 */
	public function actionAdmin()
	{                
		$this->render('content_list_admin');
	}
        
        /**
	 * The function that view Content list details
	 * 
	 */
	public function actionView()
	{         
              $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;
              $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Content list'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Content list'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('content_list_view');
	}
        
        /**
	 * The function that update Content list
	 * 
	 */
	public function actionUpdate()
	{                
                $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;                
                $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Content list'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Content list'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('content_list_update',array('id'=>$id));
	}
        
        
        /**
	 * The function is to Delete Content list
	 * 
	 */
	public function actionDelete($id)
	{                            
             GxcHelpers::deleteModel('ContentList', $id);          
	}
        
        
        public function actionDynamicTerms()
	{
	    ContentList::getDynamicTerms();
	   
	}
        
        public function actionSuggestTags()
	{
	    ContentList::suggestTags();
	   
	}
        
         public function actionSuggestContent()
	{
	    ContentList::suggestContent();
	   
	}
                    
}