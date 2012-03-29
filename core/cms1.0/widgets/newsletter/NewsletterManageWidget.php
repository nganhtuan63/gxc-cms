<?php
/**
 * This is the Widget for manage a Comment
 *
 * @author Nguyen Tuan Quyen <nguyen.tuan.quyen.it@gmail.com>
 * @version 1.0
 * @package  cmswidgets.newsletter
 *
 */
class NewsletterManageWidget extends CWidget
{
	public $newsletter_id=0;


	public function init()
	{

	}

	public function run()
	{
		$this->renderContent();
	}

	public function renderContent()
	{
		$result=null;
		$model = null;
		$criteria = new CDbCriteria;
		$sort = new CSort;

		if ($this->newsletter_id != 0)
		{
			$criteria->condition = 'newsletter_id = :newsletter_id';
			$criteria->params = array(':newsletter_id'=>$this->newsletter_id,);
			$sort->attributes = array('created_time',);
			$sort->defaultOrder = 'created_time DESC';

			$dataProvider=new CActiveDataProvider('Newsletter', array(
					'criteria'=>$criteria,
					'sort'=>$sort,
			));
		}
		else
		{
			$dataProvider=new CActiveDataProvider('Newsletter', array(
					'criteria'=>array(
							'order'=>'t.status, t.created_time DESC',
					),
			));
		}

		$this->render('cmswidgets.views.newsletter.newsletter_manage_widget',array(
				'model'=>$model,
				'result'=>$dataProvider,
		));
	}
}
