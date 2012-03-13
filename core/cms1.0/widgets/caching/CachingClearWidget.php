<?php

/**
 * This is the Widget for Clear Caching
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 *
 */
class CachingClearWidget extends CWidget
{
    
    public $visible=true;  
    
   
 
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
    	       
 		$cache_id=isset($_GET['cache_id']) ? strtolower($_GET['cache_id']) : '';
		if($cache_id){
			switch ($cache_id) {
				case 'frontend_assets':	
					$this->clearCacheAssets('frontend');		
					user()->setFlash('success',t('FRONTEND Assets cleared!'));		
					break;
				case 'frontend_cache':	
					if($this->clearCache('frontend'))		
						user()->setFlash('success',t('FRONTEND Cache cleared!'));
					else 
						user()->setFlash('error',t('Error while clear FRONTEND Cache!'));	
					break;
				case 'backend_assets':					
					$this->clearCacheAssets('backend');
					user()->setFlash('success',t('BACKEND Assets cleared!'));
					break;
				case 'backend_cache':	
					if($this->clearCache('backend'))		
						user()->setFlash('success',t('BACKEND Cache cleared!'));
					else		
						user()->setFlash('error',t('Error while clear BACKEND Cache!'));
					break;						
				default:					
					break;
			}
			Yii::app()->controller->redirect(array('becaching/clear'));
		}   
		$this->render('cmswidgets.views.caching.caching_widget',array()); 
                                 
    }   
	
	public function clearCache($where){
		switch ($where) {
				case 'frontend':
					//Send Post Request to Frontend
					$timeout = 30;
			        $curl    = curl_init();
					$pvars   = array('key'=>FRONTEND_CLEAR_CACHE_KEY);
			        curl_setopt($curl, CURLOPT_URL, FRONT_SITE_URL.'site/caching');					 
			        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			        curl_setopt($curl, CURLOPT_POST, 1);
			        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);    
			        $result = curl_exec($curl);			    
			        curl_close ($curl);			        
			        return $result=='0'?false:true;
					break;
				case 'backend':
					Yii::app()->cache->flush();
					return true;
					break;
		}
	}
	
	public function clearCacheAssets($where){
		$get_sub_folders=array();
		switch ($where) {
				case 'frontend':
					//Clear the assets folder
					$get_sub_folders=get_subfolders_name(FRONT_STORE.DIRECTORY_SEPARATOR.'assets');
					foreach($get_sub_folders as $folder){
						recursive_remove_directory(FRONT_STORE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.$folder);
					}										
					break;
				case 'backend':		
					$get_sub_folders=get_subfolders_name(BACK_STORE.DIRECTORY_SEPARATOR.'assets');
					foreach($get_sub_folders as $folder){
						recursive_remove_directory(BACK_STORE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.$folder);
					}			
					
					break;							
				default:					
					break;
			}		
		
		return;
	}
    
    
}
