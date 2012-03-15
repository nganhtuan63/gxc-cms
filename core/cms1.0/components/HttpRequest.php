<?php 

class HttpRequest extends CHttpRequest  {
       	
       public $noCsrfValidationRoutes = array();

       protected function normalizeRequest()
		{
		        parent::normalizeRequest();
		        if($this->enableCsrfValidation)
		        {
		                $url=Yii::app()->getUrlManager()->parseUrl($this);
		                foreach($this->noCsrfValidationRoutes as $route)
		                {
		                        if(strpos($url,$route)===0)
		                                Yii::app()->detachEventHandler('onBeginRequest',array($this,'validateCsrfToken'));
		                }
		        }
		}
}