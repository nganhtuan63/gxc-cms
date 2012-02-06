<?php

class TranslateBaseController extends RController{
    
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
     * override needed to check if its ajax, the redirect will be by javascript
     */
    public function redirect($url,$terminate=true,$statusCode=302){
        if(!Yii::app()->getRequest()->getIsAjaxRequest()){
            return parent::redirect($url,$terminate,$statusCode);
        }else{
            if(is_array($url)){
    			$route=isset($url[0]) ? $url[0] : '';
    			$url=$this->createUrl($route,array_splice($url,1));
    		}
            echo CHtml::script("window.top.location='$url'");
            if($terminate)
                Yii::app()->end($statusCode);
        }
    }
    /**
     * override needed to, in case of ajax requests, use renderPartial and disable the jquery
     */
    public function render($view,$data=array(),$return=false){
        if(!Yii::app()->getRequest()->getIsAjaxRequest()){
            return parent::render($view,$data,$return);
        }else{
            Yii::app()->getClientScript()->corePackages['jquery']=false;
            return parent::renderPartial($view,$data,false,true);
        }
    }
}