<?php
/**
 * Backend Menu Item Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class BemenuitemController extends BeController{
    
       
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Menu Item'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Add Menu Item'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
                 
        /**
	 * The function that do Create new Menu Item
	 * 
	 */
	public function actionCreate()
	{                
                
		$this->render('menu_item_create');
	}
        
        
       
        
        /**
	 * The function that do Manage Menu Item
	 * 
	 */
	public function actionAdmin()
	{                
		$this->render('menu_item_admin');
	}
        
        /**
	 * The function that view Menu Item details
	 * 
	 */
	public function actionView()
	{         
              $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;
              $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Menu Item'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Menu Item'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('menu_item_view');
	}
        
        /**
	 * The function that update Menu Item
	 * 
	 */
	public function actionUpdate()
	{                
                $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;                
                $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this Menu Item'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this Menu Item'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('menu_item_update',array());
	}
        
        
        /**
	 * The function is to Delete Menu Item
	 * 
	 */
	public function actionDelete($id)
	{                              
             MenuItem::ajaxDeleteModel($id);
	}
        
         /**
	 * The function is to Delete Menu Item
	 * 
	 */
	public function actionChangeOrder()
	{                                     
             MenuItem::ajaxChangeOrder();
	}
        
        /**
         * 
         * This function is generate Menu Items based on Menu Id
         */
        public function actionDynamicParentMenuItem(){
            $menu_id= (int) ($_POST['MenuItem']['menu_id']);
            MenuItem::getMenuItemFromMenu($menu_id);
        }
        
         /**
	 * This function sugget the Pages
	 * 
	 */
	public function actionSuggestPage()
	{                
            Page::suggestPage();
	}
        
         /**
	 * This function sugget Terms
	 * 
	 */
	public function actionSuggestTerm()
	{                
            MenuItem::suggestTerm();	
	}
                    
}