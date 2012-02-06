<?php
$this->pageTitle=t('Object Color details');
$this->pageHint=t('View Object Color details'); 
?>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'color-form',
    'enableAjaxValidation'=>false,
)); 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'object_id',
	'dataProvider'=>$dataProvider,
    'columns'=>array(
		array(
            'type'=>'raw',
            'value'=>'CHtml::label($data->object_id,"item_id");',
        ),                
        'object_name',        
		array(
			'type'=>'raw',
			'value'=>'CHtml::image($data->obj_image,"",array("style"=>"width:127px;height:170px"))',
		),
        array(
            'type'=>'raw',
            'value'=>'CHtml::label($data->obj_color_id,"color_id");',
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("color_select[]",$data->obj_color_id,Color::findColor(), array(
                            "ajax" => array(
                                "type"=>"POST",                                
                                "url"=>Yii::app()->createUrl("'.app()->controller->id.'/updateobject"),
                                "dataType"=>"html",
                                "data"=>array("item_selected"=>"js:$(\".selected\").find(\"label[for=\'item_id\']\").html()", 
                                              "color_selected"=>"js:$(\".selected\").find(\"select\").val()", 
                                              "YII_CSRF_TOKEN"=>Yii::app()->getRequest()->getCsrfToken()
                                              ),                   
                                "beforeSend"=>"function() {
                                                        $(\".items\").find(\"tr\").removeClass(\"changed_color\");
                                                        $(\".selected\").addClass(\"changed_color\");                                
                                                    }",                                                                
                                "success"=>"function(data)
                                                    {           
                                                        if (typeof data != \"undefined\") {
                                                            var json = eval(\"(\" + data + \")\");
                                                            if (json[\"result\"]==\"1\") {
                                                                $(\".changed_color\").find(\"label[for=\'color_id\']\").html(json[\"color\"]);
                                                                var color = \"background:HSL(\"+json[\"H\"]+\",\"+json[\"S\"]+\"%,\"+json[\"L\"]+\"%)\";
                                                                $(\".changed_color\").find(\"a\").attr(\"style\",color);
                                                                $(\".changed_color\").find(\"a\").attr(\"href\",\"obcolor/view/\"+json[\"color\"]);
                                                                return;
                                                            }
                                                        }
                                                        alert(\"Change color failed!\");                                                                                
                                                    }" 
                              ))
                        );',            
        ),
        
        array(
            'type'=>'raw',
            'value'=>'CHtml::link("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                array("obcolor/view","id"=>$data->obj_color_id),
                array("style"=>"background:HSL(".$data->color["H"].",".$data->color["S"]."%,".$data->color["L"]."%);text-decoration:none")
                )',
        ),

	),
)); 
$this->endWidget(); 
?>
