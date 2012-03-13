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
	public $blockClass; 
	
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
    
	/* Prepare for generating the code for new block based on template files
	 * 
	 * @see CCodeModel::prepare()
	 */
	public function prepare()
    {
    	//get the block ID based on the block name. Ex: 'New Example' -> 'new_example'
    	$this->blockID = GxcHelpers::encode($this->blockName, '_', false);
   	    $blockPath = COMMON_FOLDER.DIRECTORY_SEPARATOR.'front_blocks'.DIRECTORY_SEPARATOR. $this->blockID;
   	    //Get the block class based on the block name. Ex: 'New Example' -> 'NewExampleBlock'
   	    $this->blockClass = GxcHelpers::encode($this->blockName).'Block';

   	    //Get the path of new code to be generated
        $iniPath = $blockPath.DIRECTORY_SEPARATOR.'info.ini';
		$blockInputPath = $blockPath.DIRECTORY_SEPARATOR. $this->blockID.'_block_input.php';
		$blockOutputPath = $blockPath.DIRECTORY_SEPARATOR.$this->blockID.'_block_output.php'; 
		$blockClassPath = $blockPath.DIRECTORY_SEPARATOR.$this->blockClass. '.php';
		
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
}