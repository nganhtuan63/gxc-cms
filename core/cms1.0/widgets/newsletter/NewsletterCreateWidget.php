<?php
/**
* This is the Widget for create new Newsletter.
*
* @author Nguyen Tuan Quyen <nguyen.tuan.quyen.it@gmail.com>
* @version 1.0
* @package  cmswidgets.newsletter
*
*/
class NewsletterCreateWidget extends CWidget
{
	public $model = null;
	public function init()
	{
	
	}
	
	public function run()
	{
		$this->renderContent();
	}
	
	protected function renderContent()
	{
		$this->render('cmswidgets.views.newsletter.newsletter_form_widget', array('model'=> $this->model, ));
	}
}