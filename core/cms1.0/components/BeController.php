<?php

/**
 * Class of parent Controller for Backend of GXC CMS, extends from RController
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.components
 */

class BeController extends RController
{
	
        public $pageHint='';
        public $titleImage='';
		public $backend_asset='';
                
        
        public function __construct($id,$module=null)
		{
		 		 parent::__construct($id,$module);		 		
                 if(isset($_POST)){
                     $_POST = GxcHelpers::xss_clean($_POST);
                 }
                 if(isset($_GET)){
                     $_GET = GxcHelpers::xss_clean($_GET);
					
                 }
				 
				 
		}
        
        /**
         * Filter by using Modules Rights
         * 
         * @return type 
         */
        public function filters()
        {
               return array(
                   'rights',
               );
        }
           
        /**
         * List of allowd default Actions for the user
         * @return type 
         */
        public function allowedActions()
        {
               return 'login,logout';
        }
       

}