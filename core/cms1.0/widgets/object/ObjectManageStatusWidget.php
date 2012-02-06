<?php

/**
 * This is the Widget for manage a Object based on its status.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 */
class ObjectManageStatusWidget extends CWidget
{
    
    public $visible=true;
    public $type=0;
    
 
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
        $this->doAdminSearch($this->type);
    }  
    
    public function doAdminSearch($type=0){
		
		$result=null;
                switch ($type){                    
                    case ConstantDefine::OBJECT_STATUS_DRAFT :
                        $model=new Object('draft');			                                                 
                        break;
                        
                    case ConstantDefine::OBJECT_STATUS_PENDING :
                        $model=new Object('pending');                       
                        break;
                    
                     case ConstantDefine::OBJECT_STATUS_PUBLISHED :
                        $model=new Object('published');                      
                        break;
                    
                    default :
                        $model=new Object('search');                      
                        break;
                    
                }
                
                $result=$model->doSearch($type);
                
                $model->unsetAttributes(); 
                if(isset($_GET['Object'])) {
                    $model->attributes=$_GET['Object'];
                    
                }                		
                $result=$model->doSearch($type);
                
		$this->render('cmswidgets.views.object.object_manage_widget',array(
			'model'=>$model,
			'result'=>$result
		));
    }
}
