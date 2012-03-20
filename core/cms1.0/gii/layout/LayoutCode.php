<?php
Class LayoutCode extends CCodeModel
{
	public $layoutName;
	
	public $encodedLayoutName;
	public $baseClass = 'Object';
	
	public function rules()
	{
		return array_merge(parent::rules(), array(
				array('layoutName', 'required'),
				array('layoutName', 'match', 'pattern'=>'/^\w+/'),
	
		));
	}
	
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
				'layoutName'=>'Layout Name',
		));
	}
	
	/* (non-PHPdoc)
	 * Prepare for generating new layout
	 * @see CCodeModel::prepare()
	 */
	public function prepare()
	{
		//$this->encodedLayoutName = $this->encode($this->layoutName);
		$this->encodedLayoutName = GxcHelpers::encode($this->layoutName, '_', false);
		//The directory where the new code will be generated to
		$layoutPath = COMMON_FOLDER.DIRECTORY_SEPARATOR.'front_layouts'.DIRECTORY_SEPARATOR.$this->encodedLayoutName;
		
		//Get all the paths of template files
		$files = CFileHelper::findFiles($this->templatePath);
		
		foreach ($files as $file)
		{
			//Get the path of new code to be generated
			$generatedFilePath = $layoutPath.str_replace($this->templatePath, '', $file);
			//Get the path of template files (in the folder templates)
			$templateFile = $this->render($file);
			//code to be generated
			$this->files[] = new CCodeFile($generatedFilePath, $templateFile);
		}
	}
}