<?php
/**
 * Backend Settings Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class BesettingsController extends BeController{
    
       
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Settings'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Add Setting'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
                 
        /**
	 * The function that do Manage System Settings
	 * 
	 */
	public function actionSystem()
	{                
		$this->render('settings_system');
	}
        
         /**
	 * The function that do Manage General Settings
	 * 
	 */
	public function actionGeneral()
	{                
		$this->render('settings_general');
	}
        
        
                    
}