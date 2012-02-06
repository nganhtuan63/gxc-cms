<input type="hidden" value="1" name="which_button" id="which_button"/>
                                        <div class="row odd buttons border-left-silver">                                                                                       
                                            &nbsp;<lablel class="status_label" style="display: block"><?php echo t('Send to Person: '); ?></lablel>
                                            <?php $this->widget('CAutoComplete', array(
                                                    'model'=>$model,
                                                    'attribute'=>'person',
                                                    'url'=>array('suggestPeople'),
                                                    'value'=>$model->person,
                                                    'multiple'=>false,
                                                    'mustMatch'=>true,
                                                    'htmlOptions'=>array('size'=>50,'class'=>'maxWidthInput','id'=>'form_send_to'),
                                            )); ?>
                                            <?php echo CHtml::Button(t('Send'),array('style'=>'width:100px;','class'=>'button active','onClick'=>'return doFormSend();')); ?>
                                            <lablel class="status_label" style="display: block"><?php echo t('Send to: '); ?></lablel>
                                            <?php echo $form->dropDownList($model,'object_status',$content_status,array('class'=>'status_select')); ?>
                                            <?php echo CHtml::Button(t('Send'),array('class'=>'button active','onClick'=>'return doFormSave();','style'=>'display:block;width:100px')); ?>
                                                    <div class="clear"></div>

                                                    <script type="text/javascript">
                                                            function doFormSave(){
                                                                    $("#form_send_to").val('');
                                                                    $("#which_button").val(1);
                                                                    $('#object-form').submit();
                                                            }

                                                            function doFormSend(){
                                                                    var formPerson=$("#form_send_to").val();
                                                                    $("#which_button").val(2);
                                                                    //Start to check the current user is allowed to transfered to
                                                                    if(formPerson==''){
                                                                            alert('<?php echo t("Please choose a name");?>');
                                                                            return false;
                                                                    } else {
                                                                    <?php echo CHtml::ajax(array(
                                                                    'url'=>bu().'/beobject/checktransferrights', 
                                                                    'data'=>array('q'=>'js:$(\'#form_send_to\').val()', 'type'=>$type,
                                                                         'YII_CSRF_TOKEN'=>Yii::app()->getRequest()->getCsrfToken()
                                                                    ),
                                                                    'type'=>'post',
                                                                    'dataType'=>'html',
                                                                    'success'=>"function(data)
                                                                    {                                                                        
                                                                        // Update the status
                                                                        if (data=='0')
                                                                        {
                                                                            alert('".t('You are not allowed to send content to this user')."');
                                                                            return;
                                                                        } else {
                                                                            $('#object-form').submit();
                                                                            return;
                                                                        }

                                                                    } ",
                                                                    ));?>
                                                                    }
                                                                    return false;  	
                                                            }
                                                    </script>
                                            </div>