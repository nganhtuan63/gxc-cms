<?php

/**
 * Class defined all the Constant value of the OSG.
 * 
 * 
 * @author Tuan Nguyen
 * @version 1.0
 * @package common.components
 */

class OsgConstantDefine{
    
    /**
     * Constant For Fetch Folder in Common
     */ 
    const FETCH_FOLDER = 'fetch_data';
    const IMAGE_RESIZE_FOLDER = 'resize';
    const IMAGE_ORIGINAL_FOLDER = 'original';
    const IMAGE_RESIZE_HEIGHT = '217';
    const IMAGE_RESIZE_WIDTH = '162';
    const RANDOM_GET = 20;
	
	const AMAZON_SES_ACCESS_KEY='AKIAIO2P4GQIK6YLBS4Q';
	const AMAZON_SES_SECRET_KEY='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';
	const AMAZON_SES_EMAIL='no-reply@onsalegrab.com';
    /**
     * Limit CRAWL PER TIME
     */ 
    const LIMIT_CRAWL_PER_TIME=20;
    
      /**
     * Limit PARSE PER TIME
     */ 
    const LIMIT_PARSE_PER_TIME=20;
    
    
    /**
     * Limit Failed CRAWL
     */ 
    const LIMIT_FAILED_CRAWL=5;
    
     
    
    
    /**
     * Constant related to Brand Crawl
     */    
    
    const BRAND_NOT_ALLOW_CRAWL=0;
    const BRAND_ALLOW_CRAWL=1;
       
    
    public static function getBrandCrawlStatus(){
        return array(
            self::BRAND_NOT_ALLOW_CRAWL=>t("Not Allow"),
            self::BRAND_ALLOW_CRAWL=>t("Allow"));
    }
    
    
     /**
     * Constant related to Brand Parse
     */    
    
    const BRAND_NOT_ALLOW_PARSE=0;
    const BRAND_ALLOW_PARSE=1;
           
    public static function getBrandParseStatus(){
        return array(
            self::BRAND_NOT_ALLOW_PARSE=>t("Not Allow"),
            self::BRAND_ALLOW_PARSE=>t("Allow"));
    }
    
    
     /**
     * Constant related to Crawl Queue
     */    
    
    const CRAWL_STATUS_ON_WAIT=0;
    const CRAWL_STATUS_FAILED=-1;
    const CRAWL_STATUS_SUCCESS=1;
       
    
    public static function getCrawlQueueStatus(){
        return array(
            self::CRAWL_STATUS_ON_WAIT=>t("Waiting"),
            self::CRAWL_STATUS_FAILED=>t("Failed"),
            self::CRAWL_STATUS_SUCCESS=>t("Succeed")
           );
    }
    
    
    const CRAWL_AS_ROOT=1;
    const CRAWL_AS_NORMAL=0;    
       
    
    public static function getCrawlMode(){
        return array(
            self::CRAWL_AS_ROOT=>t("Root"),
            self::CRAWL_AS_NORMAL=>t("Normal"),            
           );
    }
    
    
     /**
     * Constant related to Parse Queue
     */    
    
    const PARSE_ON_WAIT=0;
    const PARSE_FOUND=1;
    const PARSE_NOT_FOUND=2;
       
    
    public static function getParseQueueStatus(){
        return array(
            self::PARSE_ON_WAIT=>t("Waiting"),
            self::PARSE_FOUND=>t("Found"),
            self::PARSE_NOT_FOUND=>t("Not Found")
           );
    }
    
    
    const PARSE_AS_ROOT=1;
    const PARSE_AS_NORMAL=0;    
       
    
    public static function getParseMode(){
        return array(
            self::PARSE_AS_ROOT=>t("Root"),
            self::PARSE_AS_NORMAL=>t("Normal"),            
           );
    }
    
    
    
    public static function getBrandsFilter($params=array()) {
        $condition = self::buildCondition($params,'brand');
        
        $dbCommand = Yii::app()->db->createCommand("
           SELECT o.obj_brand_name_id, o.obj_brand_name, count(o.object_id) as brand_count
                    FROM `gxc_osg_object_sale` o
                    WHERE ".$condition."
                    GROUP BY obj_brand_name_id
                    HAVING brand_count > 0
                    ORDER BY obj_brand_name ASC
                    ");

        $data = $dbCommand->queryAll();
        return $data;        
    }
    
    public static function getColorsFilter($params=array()) {
        $condition = self::buildCondition($params,'color');
        
        $dbCommand = Yii::app()->db->createCommand("
           SELECT o.obj_color_id, c.colorname, c.H, c.S, c.L, count(o.object_id) as color_count
                    FROM `gxc_osg_object_sale` o join `gxc_osg_color` c on o.obj_color_id = c.colorid
                    WHERE ".$condition."
                    GROUP BY o.obj_color_id
                    HAVING color_count > 0
                    ORDER BY obj_color_id DESC
                    ");

        $data = $dbCommand->queryAll();
        return $data;        
    }
    
    public static function getTermsByParentFilter($params=array(), $parent) {
        $condition = self::buildCondition($params,'cat');
        
        $dbCommand = Yii::app()->db->createCommand("
           SELECT distinct t.term_id, t.name, t.slug, t.description, count(o.object_id) as count_term
                FROM gxc_term t join gxc_object_term rel on t.term_id = rel.term_id inner join gxc_osg_object_sale o on rel.object_id = o.object_id 
                WHERE t.parent=$parent and $condition
                GROUP BY t.term_id 
                HAVING count_term>0
                ");

        $data = $dbCommand->queryAll();
        return $data;        
    }
    
    public static function getSalesFilter($params=array()) {        
        $condition = self::buildCondition($params,'sale');
        $arrDefaultSales = self::getDefaultSales();
        $sqlCommand = '';
        
        foreach ($arrDefaultSales as $defaultSale) {
        	$sqlCommand .= 'SELECT "'.$defaultSale['min'].'" as sale_id, count(object_id) as sale_count 
                FROM gxc_osg_object_sale o
                WHERE '.$condition.' and obj_sale_percent >= '.$defaultSale['min'].
                	(isset($defaultSale['max']) ? ' and obj_sale_percent <='.$defaultSale['max'] : '').' 
                HAVING sale_count>0 UNION ';
        }
        $sqlCommand = trim($sqlCommand,' UNION ');
		
		$dbCommand = Yii::app()->db->createCommand($sqlCommand);

        $data = $dbCommand->queryAll(); 
		
		return $data;           
    }
    
    public static function getPricesFilter($params=array()) {        
        $condition = self::buildCondition($params,'price');
        $arrDefaultPrices = self::getDefaultPrices();
        $sqlCommand = '';
        
        foreach ($arrDefaultPrices as $defaultPrice) {
        	$sqlCommand .= 'SELECT "'.$defaultPrice['min'].'" as price_id, count(object_id) as price_count 
                FROM gxc_osg_object_sale o
                WHERE '.$condition.' and obj_sale_price >= '.$defaultPrice['min'].
                	(isset($defaultPrice['max']) ? ' and obj_sale_price <='.$defaultPrice['max'] : '').' 
                HAVING price_count>0 UNION ';
        }
        $sqlCommand = trim($sqlCommand,' UNION ');
		
		$dbCommand = Yii::app()->db->createCommand($sqlCommand);

        $data = $dbCommand->queryAll(); 
		
		return $data;        
    }
                                        
    const PAGE_SIZE = 10;                                        
    public static function getContentList($params=array()) {                
        $condition = 't.object_status = '.ConstantDefine::OBJECT_STATUS_PUBLISHED;
        
        //brand
        if (isset($params['brand'])) {
            $condition.= ' and t.obj_brand_name_id in ('.$params['brand'].')';            
        }
        
        //sale
        if (isset($params['sale'])) {
            $sales = explode(',',$params['sale']);
			$arrDefaultSales = self::getDefaultSales();
			$condition.= ' and (0 ';
			foreach ($sales as $saleID) {
				$sale = $arrDefaultSales[$saleID];				
				$condition.= ' or (t.obj_sale_percent >= '.$sale['min'].(isset($sale['max']) ? ' and t.obj_sale_percent <='.$sale['max'] :'').')';
			}
			$condition.=')';                                        
        }
        
        //price 
        if (isset($params['price'])) {
            $prices = explode(',',$params['price']);
			$arrDefaultPrices = self::getDefaultPrices();
			$condition.= ' and (0 ';
			foreach ($prices as $priceID) {
				$price = $arrDefaultPrices[$priceID];				
				$condition.= ' or (t.obj_sale_price >= '.$price['min'].(isset($price['max']) ? ' and t.obj_sale_price <='.$price['max'] :'').')';
			}
			$condition.=')';                                        
        }
        
        //terms                
        if (isset($params['cat']))
            $condition .= ' and object_id in (select object_id from `gxc_object_term` where term_id='.$params['cat'].')';
        
        //color
        if (isset($params['color'])) {
            $condition.= ' and t.obj_color_id in ('.$params['color'].')';            
        }
        //sort
        //$criteria_field = 'object_date DESC';
        $criteria_field = 'rand()';
        
        $sort = new OsgSort('ObjectSale');
                    $sort->defaultOrder='t.obj_sale_percent DESC';
                    $sort->attributes = array(                    		
                            'obj_sale_percent' => array(                                    
                                    'asc'=>'obj_sale_percent ASC',
                                    'desc'=>'obj_sale_percent DESC',
                                    'default'=>'desc',
                            ),
                            'obj_sale_price' => array(
                                    'asc'=>'obj_sale_price ASC',
                                    'desc'=>'obj_sale_price DESC',                                    
                            ),
                            'object_date' => array(
                                    'asc'=>'object_date ASC',
                                    'desc'=>'object_date DESC',                                    
                            ),
                            'object_name' => array(
                                    'asc'=>'object_name ASC',
                                    'desc'=>'object_name DESC',                                    
                            ),
                            'obj_brand_name' => array(
                                    'asc'=>'obj_brand_name ASC',
                                    'desc'=>'obj_brand_name DESC',                                    
                            ),
                    );            
       
        			return new CActiveDataProvider('ObjectSale',array(
                                'criteria'=>array(
                                        'condition'=>$condition,                                                                               
                                ),
                                'pagination'=>array(
                                        'pageSize'=>self::PAGE_SIZE,
                                        'pageVar'=>'page'
                                ),
                                'sort'=>$sort,
                            ));               
                         
    }
    
    public static function buildCondition($params=array(), $param='') {
        $condition = "o.object_status = ".ConstantDefine::OBJECT_STATUS_PUBLISHED;
        
        //sale min max
        if ($param!='sale' && isset($params['sale']) && trim($params['sale']) != '') {
            $sales = explode(',',$params['sale']);
			$arrDefaultSales = self::getDefaultSales();
			$condition.= ' and (0 ';
			foreach ($sales as $saleID) {
				$sale = $arrDefaultSales[$saleID];				
				$condition.= ' or (o.obj_sale_percent >= '.$sale['min'].(isset($sale['max']) ? ' and o.obj_sale_percent <='.$sale['max'] :'').')';
			}
			$condition.=')';               
        }
        
        //price
        if ($param!='price' && isset($params['price']) && trim($params['price']) != '') {
            $prices = explode(',',$params['price']);
			$arrDefaultPrices = self::getDefaultPrices();
			$condition.= ' and (0 ';
			foreach ($prices as $priceID) {
				$price = $arrDefaultPrices[$priceID];				
				$condition.= ' or (o.obj_sale_price >= '.$price['min'].(isset($price['max']) ? ' and o.obj_sale_price <='.$price['max'] :'').')';
			}
			$condition.=')';                                        
        }
        
        //brand
        if ($param!='brand' && isset($params['brand']) && trim($params['brand']) != '') {
            $condition.= ' and o.obj_brand_name_id in ('.$params['brand'].')';            
        }
        
        //terms                
        if ($param!='cat' && isset($params['cat']) && trim($params['cat']) != '')
            $condition .= ' and object_id in (select object_id from `gxc_object_term` where term_id='.$params['cat'].')';
            
        //color
        if ($param!='color' && isset($params['color']) && trim($params['color']) != '') {
            $condition.= ' and o.obj_color_id in ('.$params['color'].')';            
        }
            
        return $condition;
    }
    

   
    public static function getSlug($paramsInfo, $arrGet) {
    	$cat = '';
    	if (isset($paramsInfo['cat']) && trim($paramsInfo['cat'])!='')
			$cat = $paramsInfo['cat'];
		elseif (isset($arrGet['cat']) && trim($arrGet['cat'])!='')
			$cat = $arrGet['cat'];
		
		$model = $cat!='' ? Term::model()->findByPk($cat) : null; 
		$slug = $model!=null ? $model->slug : 'all-categories';
		
		return $slug; 	
    }
	
	//mix param with existed param 
	//eg: color=1,2 & color=3 =>1,2,3
	//    color=1,2,3 & color=1,2 =>1,2
	//    color=1 & color=1 => ''
	//    '' & color=1 => 1
	public static function mixParam($arrGet, $param, $value) {
		if ($param=='cat')
			return $value;
		
		if (isset($arrGet[$param])) {
			$arrValuesGet = explode(',',$arrGet[$param]);
			$arrValues = explode(',',$value);
			//existed in values => remove
			if (in_array($arrValues[0],$arrValuesGet))
				return $value;
			
			//otherwise
			$arrValuesGet[] = $value;
			return implode(',',$arrValuesGet);
		}
		
		//param not exist
		return $value;
	}
	
    public static function buildLink($paramsInfo=array()) {
        $params = array('cat','brand','sale','price','color');
        $arrGet = self::param_get();
        $link = bu();
		$fragment = '';
		
        foreach ($params as $param) {
            $fragment .= (isset($paramsInfo[$param]) && trim($paramsInfo[$param])!='')
                        ? ($paramsInfo[$param]!='remove' 
                        	? '&'.$param.'='.self::mixParam($arrGet, $param, $paramsInfo[$param]) 
							: '')
                        : ((isset($arrGet[$param]))
                            ? '&'.$param.'='.$arrGet[$param]
                            : '');    
        }
        if (count($fragment)>0) {
			$link .= '#!'.self::getSlug($paramsInfo, $arrGet).$fragment;
		}
		
        return $link;
    }
	
    public static function buildRemoveLink($params=array(), $arg='',$id='') {
    	if (isset($params[$arg])) {
            if ($id!='' && strpos($params[$arg],',')) {
            	$arr_selected = explode(',',$params[$arg]);
                foreach ($arr_selected as $key=>$selected) {
                    if ($selected==$id) {
                        unset($arr_selected[$key]);
						break;
					}
				}
                $params[$arg] = implode(',',$arr_selected);				
            }
            else
                $params[$arg] = 'remove';            
        }
        
        return self::buildLink($params);
    }
    
    public function param_get() {
        $result = array();
        $params = array('cat','brand','sale','price','color');
        foreach ($params as $param) {
            if (isset($_GET[$param]) && trim($_GET[$param])!='') {
                $result[$param] = $_GET[$param];
            }
        }
        return $result;
    }
    
	//Ajax get categories
    public static function getCategories($params=array()) {
        $result = array();
        
		if (isset($params['cat']) && trim($params['cat'])!='') {
			//has params category
			//check if has children
			$arrTerm= OsgConstantDefine::getTermsByParentFilter($params, $params['cat']);
			if ($arrTerm==null || count($arrTerm)==0) {
				//no children
				$termModel = Term::model()->findByPk($params['cat']);
				$arrTerm= OsgConstantDefine::getTermsByParentFilter($params, $termModel->parent);
			}
		}
		else {
			//no param category
			$arrTerm= OsgConstantDefine::getTermsByParentFilter($params, '0');
		}
        
		if ($arrTerm!=null && count($arrTerm)>0) {
			foreach ($arrTerm as $_term) {
	        		$paramsInfo = array('cat'=>$_term['term_id']);                                 
	                $isSelected = (isset($params['cat']) && $_term['term_id']==$params['cat']) ? ' class="selected" ' : '';
	            	$result[] = array(
								'id'=>$_term['term_id'],
								'url'=>self::buildLink($paramsInfo),
								'select'=>$isSelected,
								'name'=>$_term['name'].' ('.$_term['count_term'].')'
							);
	        }	
		}
		
        
        return $result;            
    }
        
    //Ajax get colors
    public static function getColors($params=array()) {
        $result = array();
        $arrColors= OsgConstantDefine::getColorsFilter($params);
        if (isset($params['color']))
			$selectedColors = explode(',', $params['color']);
		
        if ($arrColors!=null && count($arrColors)>0) {
            foreach ($arrColors as $_color) {
            	$isSelected = (isset($selectedColors) && in_array($_color['obj_color_id'],$selectedColors)) ? ' selected' : '';
				$paramsInfo = array('color'=>$_color['obj_color_id']);
            	$link = $isSelected == '' ? self::buildLink($paramsInfo) : self::buildRemoveLink($params, 'color', $_color['obj_color_id']);
				$result[] = array(
								'id'=>$_color['obj_color_id'],
								'url'=>$link,
								'select'=>$isSelected,
								'name'=>$_color['colorname'].' ('.$_color['color_count'].')'
							);            
            }
        }
        
        return $result;            
    }
	
	//Get default sales
	public static function getDefaultSales() {
		return array(70 => array(
								'min' => 70,
								'label'=>'70% and above'
								),
					50 => array(
								'min' => 50,
								'max' => 70,
								'label'=>'50% to 70%'
								),
					30 => array(
								'min' => 30,
								'max' => 50,
								'label'=>'30% to 50%'
								),
					10 => array(
								'min' => 10,
								'max' => 30,
								'label'=>'10% to 30%'
								),
					0 => array(
								'min' => 0,
								'max' => 10,
								'label'=>'Under 10%'
								));
	}
	
	//Ajax get sale percents
    public static function getSales($params=array()) {
    	$arrDefaultSales = self::getDefaultSales();     
        $result = '';
        
        $arrSales= OsgConstantDefine::getSalesFilter($params);
        
		if (isset($params['sale']))
			$selectedSales = explode(',', $params['sale']);
		
        if ($arrSales!=null && count($arrSales)>0) {
            foreach ($arrSales as $_sale) {
            	$isSelected = (isset($selectedSales) && in_array($_sale['sale_id'],$selectedSales)) ? ' class="selected" ' : '';
				$paramsInfo = array('sale'=>$_sale['sale_id']);
				$label = $arrDefaultSales[$_sale['sale_id']]['label'];  
				$link = $isSelected == '' ? self::buildLink($paramsInfo) : self::buildRemoveLink($params, 'sale', $_sale['sale_id']);
				$result[] = array(
								'id'=>$_sale['sale_id'],
								'url'=>$link,
								'select'=>$isSelected,
								'name'=>$label.' ('.$_sale['sale_count'].')'
							);                               
            }
        }
        
        return $result;              
    }
	
	//Get default prices
	public static function getDefaultPrices() {
		return array(0 => array(
								'min' => 0,
								'max' => 20,
								'label'=>'Under $20'
								),
					20 => array(
								'min' => 20,
								'max' => 50,
								'label'=>'$20 to $50'
								),
					50 => array(
								'min' => 50,
								'max' => 100,
								'label'=>'$50 to $100'
								),
					100 => array(
								'min' => 100,
								'max' => 200,
								'label'=>'$100 to $200'
								),
					200 => array(
								'min' => 200,
								'label'=>'$200 & above'
								));
	}
	
	//Ajax get prices
    public static function getPrices($params=array()) {
    	$arrDefaultPrices = self::getDefaultPrices();     
        $result = array();
        
        $arrPrices= OsgConstantDefine::getPricesFilter($params);
        
		if (isset($params['price']))
			$selectedPrices = explode(',', $params['price']);
		
        if ($arrPrices!=null && count($arrPrices)>0) {
            foreach ($arrPrices as $_price) {
            	$isSelected = (isset($selectedPrices) && in_array($_price['price_id'],$selectedPrices)) ? ' class="selected" ' : '';
				$paramsInfo = array('price'=>$_price['price_id']);
				$label = $arrDefaultPrices[$_price['price_id']]['label'];
				$link = $isSelected == '' ? self::buildLink($paramsInfo) : self::buildRemoveLink($params, 'price', $_price['price_id']);
				$result[] = array(
								'id'=>$_price['price_id'],
								'url'=>$link,
								'select'=>$isSelected,
								'name'=>$label.' ('.$_price['price_count'].')'
							);              
            }
        }
        
        return $result;            
    }

	//Ajax get brands
    public static function getBrands($params=array()) {
        $result = array();
        
        $arrBrands= OsgConstantDefine::getBrandsFilter($params);
        
		if (isset($params['brand']))
			$selectedBrands = explode(',', $params['brand']);
		
        if ($arrBrands!=null && count($arrBrands)>0) {
            foreach ($arrBrands as $_brand) {
            	$isSelected = (isset($selectedBrands) && in_array($_brand['obj_brand_name_id'],$selectedBrands)) ? ' class="selected" ' : '';
				$paramsInfo = array('brand'=>$_brand['obj_brand_name_id']);
				$link = $isSelected == '' ? self::buildLink($paramsInfo) : self::buildRemoveLink($params, 'brand', $_brand['obj_brand_name_id']);
				$result[] = array(
								'id'=>$_brand['obj_brand_name_id'],
								'url'=>$link,
								'select'=>$isSelected,
								'name'=>$_brand['obj_brand_name'].' ('.$_brand['brand_count'].')'
							);                 
            }
        }
        
        return $result;            
    }   

	public static function getSelections($params=array()) {
		$result = array();
		
		$arrDefaultPrices = self::getDefaultPrices();  
		$arrDefaultSales = self::getDefaultSales();  
			
		foreach ($params as $arg=>$param) {
			$arrValues = explode(',',$param);
			
			foreach ($arrValues as $index=>$value) {
				switch ($arg) {
					case 'cat':
						$model = Term::model()->findByPk($value);
						$description = $model->description;
						$slug = $model->slug;
						break;
					case 'color':
						$model = Color::model()->findByPk($value);
						$description = $model->colorname;
						break;
					case 'brand':
						$model = Brand::model()->findByPk($value);
						$description = $model->brand_name;
						break;
					case 'sale':
						$description = $arrDefaultSales[$value]['label'];
						break;
					case 'price':
						$description = $arrDefaultPrices[$value]['label'];
						break;
					default:
						$description = 'Error';
						break;
				}
				$name = $arg.$value;
				$result[] = array('name'=>$name,
								  'param'=>self::buildRemoveLink($params, $arg, $value),
								  'description'=>$description
								);	
			}
			
		}
		
		return $result;
	}
}
















