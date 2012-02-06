<?php

/**
 * Class for render Ajax Response
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.reset_avatar
 */

class AjaxBlock extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='ajax';
    public $block=null;     
    public $errors=array();
    public $page=null;
    public $layout_asset='';
        
    
    public function setParams($params){
          return; 
    }
    
    public function run()
    {                 
           $this->renderContent();         
    }       
 
 
    protected function renderContent()
    {     
       if(isset($this->block) && ($this->block!=null)){
       			if (isset($_GET['type'])) {
			        if ($_GET['type']=='filter')
			            $this->getAjaxFilter();
			        else
			            $this->getAjaxContent();
			        return;
			    }
				Yii::app()->end();	                                                            	       		     
		} else {
		    echo '';
		}
       
    }
    
    public function validate(){	
		return true ;
    }
    
    public function params()
    {
         return array();
    }
    
    public function beforeBlockSave(){
	return true;
    }
    
    public function afterBlockSave(){
	return true;
    }
	
	public function getAjaxFilter()
    {
        $params = OsgConstantDefine::param_get();	        
        $result['cat'] =  OsgConstantDefine::getCategories($params);
		$result['color'] =  OsgConstantDefine::getColors($params);
		$result['brand'] =  OsgConstantDefine::getBrands($params);
		$result['price'] =  OsgConstantDefine::getPrices($params);
		$result['sale'] =  OsgConstantDefine::getSales($params);
        $result['select'] =  OsgConstantDefine::getSelections($params);    
		echo json_encode($result);        
    }
	    
    public function getAjaxContent()
    {

		$data_items=array();		
		if(isset($_GET['stop'])){
			$data_items['result']='no';			
			$data_items['items']=array();
		} else {
			$params = OsgConstantDefine::param_get();	
        	$content_list = OsgConstantDefine::getContentList($params);
			if($content_list->totalItemCount>0){
				$data_items['result']='yes';
				$data_items['page_current']=(isset($_GET['page'])&&(int)$_GET['page'] > 0) ? (int)$_GET['page'] : 1; 
				$data_items['total']=$content_list->totalItemCount; 				
				foreach($content_list->data as $data_item){
					$item=array();
					$item['name']=$data_item->object_name;
					$item['link']=FRONT_SITE_URL."/item/".$data_item->object_id."/".$data_item->object_slug;
					$item['link_to_site']=$data_item->obj_link;
					$item['img']= $data_item->obj_resize==1  ? (IMAGES_URL."/".OsgConstantDefine::IMAGE_RESIZE_FOLDER."/".$data_item->obj_local_image) 
		                           : $data_item->obj_image  ;
					$item['title']= $data_item->object_title;                          
		            $item['style']=   $data_item->obj_resize!=1 ? "style='width:".OsgConstantDefine::IMAGE_RESIZE_WIDTH."px;height:".OsgConstantDefine::IMAGE_RESIZE_HEIGHT."px'" : "";
					$item['brand_name'] = $data_item->obj_brand_name;
					$item['slug'] = $data_item->object_slug;
					$item['regular_price'] = $data_item->obj_regular_price;
					$item['sale_price'] = $data_item->obj_sale_price;
					$item['sale_percent'] = $data_item->obj_sale_percent;			                                                                                         
					$data_items['items'][]=$item;
				}			
			
			} else {
				$data_items['result']='no';			
				$data_items['items']=array();
			}
		}
		
		
		echo json_encode($data_items);
		Yii::app()->end();
		 			
    }
}

?>