<?php Yii::app()->controller->pageTitle = TranslateModule::t('Missing Translations')." - ".TranslateModule::translator()->acceptedLanguages[Yii::app()->getLanguage()]?>
<?php 
$source=MessageSource::model()->findAll();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'message-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
        array(
            'name'=>'message',
            'filter'=>CHtml::listData($source,'message','message'),
        ),
        array(
            'name'=>'category',
            'filter'=>CHtml::listData($source,'category','category'),
        ),
                     
        array(
            'class'=>'CButtonColumn',
            'template'=>'{create}',            
            'buttons'=>array(
                'create' => array
                (
                    'label'=>TranslateModule::t('Create'),
                    'url'=>'Yii::app()->getController()->createUrl("create",array("id"=>$data->id,"language"=>Yii::app()->getLanguage()))',                   
                    'imageUrl'=>false,
                    
                ),              
                
            ),
            'header'=>TranslateModule::translator()->dropdown(),
        ),
        array
        (
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'deleteButtonUrl'=>'Yii::app()->getController()->createUrl("missingdelete",array("id"=>$data->id))',
            'buttons'=>array
            (
                'delete' => array
                (
                    'label'=>t('Delete'),
                    'imageUrl'=>false,
                    
                ),

            ),
        ),                 
	),
)); ?>