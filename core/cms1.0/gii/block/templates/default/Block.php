<?php echo "<?php\n"; ?>

/**
 * Class for render <?php echo $this->blockName; ?>
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package common.front_blocks.<?php echo $this->getBlockID($this->blockName); ?>
 */

class <?php echo $this->getBlockClass($this->blockName); ?> extends CWidget
{
    
    //Do not delete these attr block, page and errors
    public $id='<?php echo $this->getBlockID($this->blockName); ?>';
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
       			//Start working with <?php echo $this->blockName; ?> here
				                                                          	       		     
		}
		Yii::app()->end();	  
       
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
	
	
}

?>