<?php
/**
 * Backend Object Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class BeobjectController extends BeController
{
        public function __construct($id,$module=null)
	{
		 parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Content'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Create Content'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
		 
	}
        
        /**
	 * The function that do Create new Object
	 * 
	 */
	public function actionCreate()
	{                
		$this->render('object_create');
	}
        
         /**
         * The function that do Update Object
         * 
         */
	public function actionUpdate()
	{            
              $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;
              $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this content'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this content'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
              
              $this->render('object_update');
	}
        
         /**
	 * The function that do View User
	 * 
	 */
	public function actionView()
	{         
              $id=isset($_GET['id']) ? (int) ($_GET['id']) : 0 ;
              $this->menu=array_merge($this->menu,                       
                        array(
                            array('label'=>t('Update this content'), 'url'=>array('update','id'=>$id),'linkOptions'=>array('class'=>'button')),
                            array('label'=>t('View this content'), 'url'=>array('view','id'=>$id),'linkOptions'=>array('class'=>'button'))
                        )
                    );
		$this->render('object_view');
	}
        /**
	 * The function that do Manage Object
	 * 
	 */
	public function actionAdmin()
	{                
		$this->render('object_admin',array('type'=>0));
	}
        
        /**
	 * The function that do Manage Pending Object
	 * 
	 */
	public function actionPending()
	{                
		$this->render('object_admin',array('type'=>  ConstantDefine::OBJECT_STATUS_PENDING));
	}
        
         /**
	 * The function that do Manage Draft Object
	 * 
	 */
	public function actionDraft()
	{                
		$this->render('object_admin',array('type'=>  ConstantDefine::OBJECT_STATUS_DRAFT));
	}
        
         /**
	 * The function that do Manage Object
	 * 
	 */
	public function actionPublished()
	{                
		$this->render('object_admin',array('type'=>  ConstantDefine::OBJECT_STATUS_PUBLISHED));
	}
        
        
      
        /**
	 * This function sugget Person that the current user can send content to
	 * 
	 */
	public function actionSuggestPeople()
	{                
		$this->widget('cmswidgets.object.ObjectExtraWorkWidget',array('type'=>'suggest_people'));
	}
        
         /**
	 * This function sugget Person that the current user can send content to
	 * 
	 */
	public function actionCheckTransferRights()
	{                
		$this->widget('cmswidgets.object.ObjectExtraWorkWidget',array('type'=>'check_transfer_rights'));
	}
        
        
        /**
	 * This function sugget Tags for Object
	 * 
	 */
	public function actionSuggestTags()
	{         
            
		$this->widget('cmswidgets.object.ObjectExtraWorkWidget',array('type'=>'suggest_tags'));
	}
        
        /**
	 * The function is to Delete a Content
	 * 
	 */
	public function actionDelete($id)
	{                            
            GxcHelpers::deleteModel('Object', $id);
	}
          
        
}