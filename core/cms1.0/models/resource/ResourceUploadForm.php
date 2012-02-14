<?php

class ResourceUploadForm extends CFormModel
{
    public $name;
    public $body;
    public $link;
    public $upload;
    public $type;
	public $where;
    
    public function rules()
    {
        return array(
            array('link, name, body, type,where','safe'),
            array('upload', 'file','allowEmpty'=>true),
            
        );
    }
	
	
    public function attributeLabels()
    {
            return array(
                    'upload'=>t('Upload'),
                    'link'=>t('Link'),
                    'name'=>t('Resource Name'),
                    'body'=>t('Description'),
                    'where'=>t('Storage'),
					'type'=>t('File type')
            );
    }
    
    
}