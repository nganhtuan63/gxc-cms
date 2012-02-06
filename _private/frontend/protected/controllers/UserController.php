<?php

class UserController extends FeController
{	
        
        public $defaultAction='logout';
        
        /**
         * List of allowd default Actions for the user
         * @return type 
         */
        public function allowedActions()
        {
               return 'logout';
        }
        
          /**
         * Logout Action
         * @return type 
         */
        public function actionLogout()
        {
               Yii::app()->user->logout();
               $this->redirect(bu()); 
        }

	
}