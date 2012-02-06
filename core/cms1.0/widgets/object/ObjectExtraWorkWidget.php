<?php

/**
 * This is the Widget for suggest a People that User can send content to
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 */
class ObjectExtraWorkWidget extends CWidget
{
    
        public $visible=true; 
        public $type='suggest_people';

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
            switch ($this->type){
                case 'suggest_people':
                    if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
                    {            
                            $users=User::suggestPeople($keyword);
                            if($users!==array())
				echo implode("\n",$users);
                            
                    }
                    Yii::app()->end(); 
                    break;
                case 'check_transfer_rights':
                    if(isset($_POST['q']) && ($keyword=trim($_POST['q']))!=='' && (isset($_POST['type'])) && ($type=trim($_POST['type']))!=='' )
                    {
                            echo $this->checkTransferRights($keyword,$type);
                    }
                    Yii::app()->end(); 
                    break;

                case 'suggest_tags':                
                    if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
                    {                    
                            echo $this->suggestTags($keyword);
                    }
                    Yii::app()->end(); 
                    break;

            }


        }   


         /**
         * Check transfer rights
         * This is called via AJAX when the user is entering the Send button
         */
        public function checkTransferRights($keyword,$type)
        {
                $types=GxcHelpers::getAvailableContentType();
                $user=User::findPeople($keyword);                
                if($user!=null){                                
                        $params['to_user_id']=$user->user_id;
                        $data=null;
                        
                        Yii::import('common.content_type.'.$type.'.'.$types[$type]['class']);
                        $permissions=$types[$type]['class']::Permissions();
                        
                        if(GxcContentPermission::checkTransferTo($params,$data,$permissions)){
                                return "1";
                        }
                }
                return "0";
        }

         /**
         * Suggest Tags for Object
         * @param type $keyword 
         */
        public  function suggestTags($keyword){                
            $tags=Tag::model()->suggestTags($keyword);
            if($tags!==array())
                    echo implode("\n",$tags);                       
        }

        
        
        
        
}
