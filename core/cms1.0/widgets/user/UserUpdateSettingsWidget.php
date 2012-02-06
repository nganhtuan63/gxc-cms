<?php

/**
 * This is the Widget for User update his own settings.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cmswidgets.user
 *
 */
class UserUpdateSettingsWidget extends CWidget
{
    
    public $visible=true; 
 
    public function init()
    {
        
    }
 
    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }
 
    protected function renderContent()
    {
        if(!user()->isGuest) {
            
            $user=User::model()->findbyPk(user()->id);                       
            $model=new UserSettingsForm;
           
            //Bind Value from User to
            $model->display_name=$user->display_name;
            $model->email=$user->email;
            
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='userupdatesettings-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    
            // collect user input data
            if(isset($_POST['UserSettingsForm']))
            {
                    $model->attributes=$_POST['UserSettingsForm'];
                    
                    // validate user input password
                    if($model->validate()){
                            $u=User::model()->findbyPk(user()->id);
                            $u->scenario='update';
                            if($u!==null){                                   
                                    $u->display_name=$model->display_name;
                                    $u->email=$model->email;
                                    if($u->save()){               
                                        user()->setFlash('success',t('Updated Successfully!'));                                        
                                    }
                            }
                            $model->display_name=$u->display_name;
                            $model->email=$u->email;
            
                    }
            }
            
            $this->render('cmswidgets.views.user.user_update_settings_widget',array('model'=>$model));
        } else {
             Yii::app()->request->redirect(user()->returnUrl);                
        }

    }   
}
