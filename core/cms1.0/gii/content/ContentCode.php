<?php
/**
 * ContentCode class do the main functionality in generating new content type
 * @author TQNguyen
 *
 */
class ContentCode extends CCodeModel
{
	public $contentName;	// content name zone that will be filled by user before generating code 
	public $contentId;		// content ID zone that will be filled by user before generating code 
	
	public $baseClass = 'Object';
	
	public function rules()
    {
        return array_merge(parent::rules(), array(
            array('contentName, contentId', 'required'),
            array('contentName, contentId', 'match', 'pattern'=>'/^\w+$/'),
          
        ));
    }
    
 	public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'contentName'=>'Content Name',
        	'contentId'=>'Content ID',
        ));
    }
    
	/* Main function that generates the code for new content based on template files
	 * 
	 * @see CCodeModel::prepare()
	 */
	public function prepare()
    {
   	    $contentPath = COMMON_FOLDER.'\content_type\\'. lcfirst($this->contentName);

   	    //Get the path of new code to be generated
        $iniPath = $contentPath. '\info.ini';
		$objectPath = $contentPath. '\\'. $this->getContentClass(). '.php';
		$widgetPath = $contentPath. '\object_form_widget.php'; 
		$iconPath = $contentPath. '\assets\richtext.png';
		
		//Get the path of template files (in the folder templates)
        $iniFile = $this->render($this->templatepath.'\info.ini');
 		$objectFile = $this->render($this->templatepath.'\content.php');
 		$widgetFile = $this->render($this->templatePath. '\object_form_widget.php');
 		$iconFile = $this->render($this->templatePath. '\assets\richtext.png');
 		
 		//generate code
        $this->files[]=new CCodeFile($iniPath, $iniFile);
        $this->files[]=new CCodeFile($objectPath, $objectFile);
        $this->files[]=new CCodeFile($widgetPath, $widgetFile);
        $this->files[]=new CCodeFile($iconPath, $iconFile);
    }
    
    public function getContentClass()
    {
    	return ucfirst($this->contentName).'Object';
    }
}