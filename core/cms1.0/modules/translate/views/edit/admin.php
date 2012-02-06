<?php Yii::app()->controller->pageTitle = TranslateModule::t('Manage Messages')?>

<?php 
$source=MessageSource::model()->findAll();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'message-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'id',
            'filter'=>CHtml::listData($source,'id','id'),
        ),
        array(
            'name'=>'message',
            'filter'=>CHtml::listData($source,'message','message'),
        ),
        array(
            'name'=>'category',
            'filter'=>CHtml::listData($source,'category','category'),
        ),
        array(
            'name'=>'language',
            'filter'=>CHtml::listData($model->findAll(new CDbCriteria(array('group'=>'language'))),'language','language')
        ),
        'translation',
        array
        (
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>t('Edit'),
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->getController()->createUrl("update",array("id"=>$data->id,"language"=>$data->language))',
                ),
            ),
        ),
        array
        (
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array
            (
                'delete' => array
                (
                    'label'=>t('Delete'),
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->getController()->createUrl("delete",array("id"=>$data->id,"language"=>$data->language))',
                ),

            ),
        ),            
        
	),
)); ?>
