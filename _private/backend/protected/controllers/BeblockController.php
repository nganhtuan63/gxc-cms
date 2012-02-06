<?php
/**
 * Backend Block Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class BeblockController extends BeController{
    
       
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Block'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Add Block'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
                 
        /**
	 * The function that do Create new Block
	 * 
	 */
	public function actionCreate()
	{                
		$this->render('block_create');
	}
        
       
        
        /**
	 * The function that do Manage Block
	 * 
	 */
	public function actionAdmin()
	{                
		$this->render('block_admin');
	}
        
        /**
	 * The function that view Block details
	 * 
	 */
	public function actionView()
	{         
              $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;
              $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Block'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Block'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('block_view');
	}
        
        /**
	 * The function that update Block
	 * 
	 */
	public function actionUpdate()
	{                
                $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;                
                $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Block'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Block'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('block_update',array('id'=>$id));
	}
        
        
        /**
	 * The function is to Delete Block
	 * 
	 */
	public function actionDelete($id)
	{                            
             GxcHelpers::deleteModel('Block', $id);          
	}
        
        
        public function actionSuggestBlock()
        {
            $this->render('block_suggest',array());   
        }
        
        
        public function actionSuggestBlocks(){
              Block::suggestBlocks();
        }
        
      
                    
}