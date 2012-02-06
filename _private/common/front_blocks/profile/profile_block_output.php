<div class="form-stacked">
  
        <?php $this->render('cmswidgets.views.notification_frontend'); ?>
      
    
        
           
        <h3 style="border-bottom:1px dotted #CCC; margin-bottom:10px"><?php echo t('Thông tin cá nhân'); ?></h3>     
           
        
    
        <?php $form=$this->beginWidget('CActiveForm', array(
           'id'=>'profile-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),     
            )); 
        ?>
     
        <div  class="clearfix">
              <label>Họ và tên</label>
                <div class="input">
              <?php echo $form->textField($model,'display_name',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'display_name',array()); ?>
              </div>
        </div>
        <div  class="clearfix">
             <label>Email</label>
                <div class="input">
              <?php echo $form->textField($model,'email',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'email',array()); ?>
              </div>
        </div>
        <div  class="clearfix">
             	<label>Mô tả về bạn</label>
                <div class="input">
              <?php echo $form->textArea($model,'bio',array('autoComplete'=>'off','style'=>'height:120px; width:400px')); ?>              
              <?php echo $form->error($model,'bio',array()); ?>
              </div>
        </div>
        <iframe src="<?php echo bu();?>/avatar" style="overflow-x:hidden; overflow-y:scroll; width:100%; height:240px"></iframe>           
        
       
		<h3 style="border-bottom:1px dotted #CCC; margin-bottom:10px"><?php echo t('Tuỳ chọn'); ?></h3>   
      
         <div  class="clearfix">
                  <label>Giới tính</label>
                    <div class="input">
                  <?php echo $form->dropDownList($model,'gender',array('male'=>'Male','female'=>'Female','other'=>'Other'),array('empty'=>'')); ?>
                  <?php echo $form->error($model,'gender',array('style'=>'width: 540px;margin-left: 170px;')); ?>
                  </div>
         </div>
        <div  class="clearfix">
                  <label>Ngày sinh</label>
                    <div class="input">
              <?php echo $form->dropDownList($model,'birthday_month',array('january'=>'January',
                  'febuary'=>'Febuary',
                  'march'=>'March',
                  'april'=>'April',
                  'may'=>'May',
                  'june'=>'June',
                  'july'=>'July',
                  'august'=>
                  'August',
                  'september'=>'September',
                  'october'=>'October',
                  'november'=>'November',
                  'december'=>'December'),array('empty'=>'')); ?>
              <?php 
                    $arr_date=Yii::app()->cache->get('profile_arr_date');                                                    
                    if($arr_date===false)
                    {                   
                        $arr_date=array();
                        for($i=1;$i<=31;$i++){
                            $arr_date[$i]=$i;
                        }
                        Yii::app()->cache->set('profile_arr_date', $arr_date, 201600);
                    }
                    echo $form->dropDownList($model,'birthday_day',
                        $arr_date,
                      array('empty'=>'')); ?>
              <?php 
                    $arr_year=Yii::app()->cache->get('profile_arr_year');                                                    
                    if($arr_year===false)
                    {                   
                        $arr_year=array();
                        for($i=1933;$i<=2010;$i++){
                            $arr_year[$i]=$i;
                        }
                        Yii::app()->cache->set('profile_arr_year', $arr_year, 201600);
                    }
              echo $form->dropDownList($model,'birthday_year',$arr_year,array('empty'=>'')); ?>
              </div>              
         </div>
        <div class="clearfix">
              <label>Địa điểm</label>
              <?php echo $form->textField($model,'location',array('autoComplete'=>'off')); ?>              
              <?php echo $form->error($model,'location',array('style'=>'width: 540px;margin-left: 170px;')); ?>
         </div>
        
    
       
    
        <div class="actions">
            <?php echo CHtml::submitButton(t('Cập nhật'),array('class'=>'btn primary','id'=>'bUpdate')); ?>

        </div>
         <?php $this->endWidget(); ?>
    </div>
    
