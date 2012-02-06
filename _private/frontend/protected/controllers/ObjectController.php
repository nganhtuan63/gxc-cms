<?php

class ObjectController extends FeController
{	
        
        public $defaultAction='view';
        /**
         * List of allowd default Actions for the user
         * @return type 
         */
        public function allowedActions()
        {
               return 'view';
        }
        
     
		/**
		 * When viewing a Page
		 */
		public function actionView($id)
		{
			   	                                 
            parent::renderPageSlug('item'); 
		}
	        
	        	

	
}