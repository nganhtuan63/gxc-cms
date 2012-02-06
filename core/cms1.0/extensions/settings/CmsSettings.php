<?php
/**
 * CmsSettings
 * 
 * @package OneTwist CMS  
 * @author twisted1919 (cristian.serban@onetwist.com)
 * @copyright OneTwist CMS (www.onetwist.com)
 * @version 1.1d
 * @since 1.0
 * @access public
 */
class CmsSettings extends CApplicationComponent
{

    protected $_saveItemsToDatabase=array();
    protected $_deleteItemsFromDatabase=array();
    protected $_deleteCategoriesFromDatabase=array();
    protected $_cacheNeedsFlush=array();
    
    protected $_items=array();
    protected $_loaded=array();

    public $cacheId='global_website_settings';
    public $cacheTime=0;

    public function init()
    {
        parent::init();
        Yii::app()->attachEventHandler('onEndRequest', array($this, 'whenRequestEnds'));
    }


    public function set($category='system', $key='', $value='', $toDatabase=true)
    { 
        if(is_array($key))
        {
            foreach($key AS $k=>$v)
                $this->set($category, $k, $v, $toDatabase);
        }
        else
        {
            if($toDatabase)
            {
                if(isset($this->_saveItemsToDatabase[$category])&&is_array($this->_saveItemsToDatabase[$category]))
                    $this->_saveItemsToDatabase[$category]=array_merge($this->_saveItemsToDatabase[$category], array($key=>$value));
                else
                    $this->_saveItemsToDatabase[$category]=array($key=>$value);
            }
            if(isset($this->_items[$category])&&is_array($this->_items[$category]))
                $this->_items[$category]=array_merge($this->_items[$category], array($key=>$value));
            else
                $this->_items[$category]=array($key=>$value); 
        }
        return $this;   
    }

    public function get($category='system', $key='', $default='')
    {
        if(!isset($this->_loaded[$category]))
            $this->load($category);

        if(empty($key)&&empty($default)&&!empty($category))
            return isset($this->_items[$category])?$this->_items[$category]:null;

        if(!empty($key)&&is_array($key))
        {
            $toReturn=array();
			foreach($key AS $k=>$v)
            {
				if(is_numeric($k))
					$toReturn[$v]=$this->get($category, $v);
                else
                    $toReturn[$k]=$this->get($category, $k, $v);
			}
			return $toReturn;
        }
        
        if(isset($this->_items[$category][$key]))
            return $this->_items[$category][$key];
        return !empty($default)?$default:null;
    }

    public function delete($category='', $key='')
    {
        if(empty($category))
            return $this;
        
        if(!empty($category)&&empty($key))
        {
            $this->_deleteCategoriesFromDatabase[]=$category;
            if(isset($this->_items[$category]))
                unset($this->_items[$category]);
            return;
        }
        if(is_array($key))
        {
            foreach($key AS $k)
                $this->delete($category, $k);
        }
        else
        {
            if(isset($this->_items[$category][$key]))
            {
                unset($this->_items[$category][$key]);
                if(empty($this->_deleteItemsFromDatabase[$category]))
                    $this->_deleteItemsFromDatabase[$category]=array();
                $this->_deleteItemsFromDatabase[$category][]=$key;
            }    
        }
        return $this;
    }

    public function load($category)
    {        
        $items=Yii::app()->cache->get($category.'_'.$this->getCacheId());
        $this->_loaded[$category]=true;
        
        if(!$items)
        {
            $connection=Yii::app()->getDb();
            $command=$connection->createCommand('SELECT * FROM {{settings}} WHERE category=:cat');
            $command->bindParam(':cat',$category);
            $result=$command->queryAll();
            
            if(empty($result))
                return;

            $items=array();
            foreach($result AS $row)
                $items[$row['key']] = @unserialize($row['value']);
            Yii::app()->cache->add($category.'_'.$this->getCacheId(), $items, $this->getCacheTime()); 
        }

        if(isset($this->_items[$category]))
            $items=array_merge($items, $this->_items[$category]);
        
        $this->set($category, $items, null, false); 
        return $items;
    }
    
    public function toArray()
    {
        return $this->_items;
    }

    public function setCacheTime($int)
    {
        $this->cacheTime=(int)$int>0?$int:0;
    }

    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    public function setCacheId($str='')
    {
        $this->cacheId=!empty($str)?$str:$this->cacheId;
    }

    public function getCacheId()
    {
        return $this->cacheId;
    }
    
    
    private function addDbItem($category='system', $key, $value)
    {
        $connection=Yii::app()->getDb();
        $command=$connection->createCommand('SELECT * FROM {{settings}} WHERE `category`=:cat AND `key`=:key LIMIT 1');
        $command->bindParam(':cat',$category);
        $command->bindParam(':key',$key);
        $result=$command->queryRow();
        $value=@serialize($value);
        
        if(!empty($result))
            $command=$connection->createCommand('UPDATE {{settings}} SET `value`=:value WHERE `category`=:cat AND `key`=:key');
        else
            $command=$connection->createCommand('INSERT INTO {{settings}} (`category`,`key`,`value`) VALUES(:cat,:key,:value)');

        $command->bindParam(':cat',$category);
        $command->bindParam(':key',$key);
        $command->bindParam(':value',$value);
        $command->execute();
    }

    protected function whenRequestEnds()
    {
        $this->_cacheNeedsFlush=array();
        
        if(count($this->_deleteCategoriesFromDatabase)>0)
        {
            foreach($this->_deleteCategoriesFromDatabase AS $catName)
            {
                $connection=Yii::app()->getDb();
                $command=$connection->createCommand('DELETE FROM {{settings}} WHERE `category`=:cat');
                $command->bindParam(':cat',$catName);
                $command->execute();
                $this->_cacheNeedsFlush[]=$catName;
                
                if(isset($this->_deleteItemsFromDatabase[$catName]))
                    unset($this->_deleteItemsFromDatabase[$catName]);
                if(isset($this->_saveItemsToDatabase[$catName]))
                    unset($this->_saveItemsToDatabase[$catName]);
            }
        }
        
        if(count($this->_deleteItemsFromDatabase)>0)
        {
            foreach($this->_deleteItemsFromDatabase AS $catName=>$keys)
            {
                $params=array();
                $i=0;
                foreach($keys AS $v)
                {
                    if(isset($this->_saveItemsToDatabase[$catName][$v]))
                        unset($this->_saveItemsToDatabase[$catName][$v]);
                    $params[':p'.$i]=$v; 
                    ++$i;
                }
                $names=implode(',', array_keys($params));
                
                $connection=Yii::app()->getDb();
                $query='DELETE FROM {{settings}} WHERE `category`=:cat AND `key` IN('.$names.')';
                $command=$connection->createCommand($query);
                $command->bindParam(':cat',$catName);
                
                foreach($params AS $key=>$value)
                    $command->bindParam($key,$value);
                
                
                $command->execute();
                $this->_cacheNeedsFlush[]=$catName;
            }
        }
        
        if(count($this->_saveItemsToDatabase)>0)
        {
            foreach($this->_saveItemsToDatabase AS $catName=>$keyValues)
            {
                foreach($keyValues AS $k=>$v)
                    $this->addDbItem($catName, $k, $v);
                $this->_cacheNeedsFlush[]=$catName;
            }   
        }
        
        if(count($this->_cacheNeedsFlush)>0)
        {
            foreach($this->_cacheNeedsFlush AS $catName)
                Yii::app()->cache->delete($catName.'_'.$this->getCacheId());
        }   
    } 
    
}