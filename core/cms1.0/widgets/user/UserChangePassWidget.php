<?php

/**
 * This is the Widget for Changing Password.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.user
 *
 */
class UserChangePassWidget extends CWidget
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
            $model=new UserChangePassForm;		
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='userchangepass-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    
            // collect user input data
            if(isset($_POST['UserChangePassForm']))
            {
                    $model->attributes=$_POST['UserChangePassForm'];
                    
                    // validate user input password
                    if($model->validate()){
                            $u=User::model()->findbyPk(user()->id);
                            if($u!==null){
                                    $u->password=$u->hashPassword($model->new_password_1,  ConstantDefine::USER_SALT);
                                    $u->salt=ConstantDefine::USER_SALT;
                                    if($u->save()){               
                                        user()->setFlash('success',t('Changed Password Successfully!'));                                        
                                    }
                            }
                            $model=new UserChangePassForm;

                    }
            }
            
            $this->render('cmswidgets.views.user.user_change_pass_widget',array('model'=>$model));
        } else {
             Yii::app()->request->redirect(user()->returnUrl);
                
        }

    }   
}
