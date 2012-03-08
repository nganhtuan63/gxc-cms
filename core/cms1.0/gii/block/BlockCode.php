<?php
/**
 * BlockCode class do the main functionality in generating new block type
 * @author TQNguyen
 *
 */
class BlockCode extends CCodeModel
{
	public $blockName;	// block name zone that will be filled by user before generating code
	public $blockID; 
	
	public $baseClass = 'Object';
	
	public function rules()
    {
        return array_merge(parent::rules(), array(
            array('blockName', 'required'),
            array('blockName', 'match', 'pattern'=>'/^\w+/'),
          
        ));
    }
    
 	public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'blockName'=>'Block Name',
        ));
    }
    
	/* Main function that generates the code for new block based on template files
	 * 
	 * @see CCodeModel::prepare()
	 */
	public function prepare()
    {
    	$blockID = $this->getBlockID($this->blockName);
   	    $blockPath = COMMON_FOLDER.DIRECTORY_SEPARATOR.'front_blocks'.DIRECTORY_SEPARATOR. $blockID;
   	    $blockClass = $this->getBlockClass($this->blockName);

   	    //Get the path of new code to be generated
        $iniPath = $blockPath.DIRECTORY_SEPARATOR.'info.ini';
		$blockInputPath = $blockPath.DIRECTORY_SEPARATOR. $blockID.'_block_input.php';
		$blockOutputPath = $blockPath.DIRECTORY_SEPARATOR.$blockID.'_block_output.php'; 
		$blockClassPath = $blockPath.DIRECTORY_SEPARATOR.$blockClass. '.php';
		
		//Get the path of template files (in the folder templates)
        $iniFile = $this->render($this->templatepath.DIRECTORY_SEPARATOR.'info.ini');
 		$blockInputFile = $this->render($this->templatepath.DIRECTORY_SEPARATOR.'block_input.php');
 		$blockOutputFile = $this->render($this->templatePath.DIRECTORY_SEPARATOR.'block_output.php');
 		$blockClassFile = $this->render($this->templatePath.DIRECTORY_SEPARATOR.'Block.php');
 		
 		//generate code
        $this->files[]=new CCodeFile($iniPath, $iniFile);
        $this->files[]=new CCodeFile($blockInputPath, $blockInputFile);
        $this->files[]=new CCodeFile($blockOutputPath, $blockOutputFile);
        $this->files[]=new CCodeFile($blockClassPath, $blockClassFile);
    }
    
    /**
     * This function returns the block id based on the block name. For example :
     * Block name = 'New Example' => Block id = 'new_example'
     * @param unknown_type $blockName
     */
    public function getBlockID($blockName)
    {
    	$blockID = null;
    	if(!isset($this->blockID))
    	{
    		$blockID = preg_replace('/\s[\s]+/','_',$blockName);    // Strip off multiple spaces 
    		$blockID = preg_replace('/[\s\W]+/','_',$blockID);    // Strip off spaces and non-alpha-numeric 
    		$blockID = preg_replace('/^[\_]+/','',$blockID); // Strip off the starting '_'
    		$blockID = preg_replace('/[\_]+$/','',$blockID); // // Strip off the ending '_'
    		$blockID = strtolower($blockID); 
    		$this->blockID = $blockID;
    	}
    	return $this->blockID;
    }
    
    /**
     * This function returns the block class name which is defined in the BlockCode.php. For ex:
     * Block name = 'New Example' => Block class name = 'NewExamplelBlock'
     * @param unknown_type $blockName
     * @return string
     */
    public function getBlockClass($blockName)
    {
    	$blockClass = ucwords(strtolower($blockName));
    	$blockClass = preg_replace('/\s[\s]+/','',$blockClass);    // Strip off multiple spaces 
    	$blockClass = preg_replace('/[\s\W]+/','',$blockClass);    // Strip off spaces and non-alpha-numeric
    	return $blockClass.'Block';
    }
}