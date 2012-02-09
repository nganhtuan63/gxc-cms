<?php

/**
 * This is the Widget for update the Content.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package  cmswidgets.object
 *
 */
class ObjectUpdateWidget extends CWidget
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
        
            $id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $model=  GxcHelpers::loadDetailModel('Object', $id);
		
            //We start to implement the checking Permission HERE
            $param_content_check=array();
            $data_content_check=array();
            $param_content_check['type']=$model->object_type;
            $param_content_check['new_content']=false;
            $param_content_check['content_status']=$model->object_status;
            $param_content_check['content_author']=$model->object_author;


            //Get current trans_to of the object
            $trans=Transfer::model()->findAll(array(
                'condition'=>' object_id=:obj ',
                'params'=>array(':obj'=>$model->object_id),
                'order'=>'transfer_id DESC'
            ));

            $param_content_check['check_trans_note']=false;
            
            if(($trans!=null) && (count($trans)>0)){
                    $latest_trans_to=$trans[0];
                    $param_content_check['trans_type']=$latest_trans_to->type;
                    $param_content_check['trans_to']=$latest_trans_to->to_user_id;
                    $param_content_check['trans_note']=$latest_trans_to->note;
            }
            
               //Get Types list and type of the Object
            $types= GxcHelpers::getAvailableContentType();
            $type=(string)$model->object_type;
            
             //Import the Content Type Class
             Yii::import('common.content_type.'.$type.'.'.$types[$type]['class']);
            
            
            //Check if the User has the Permission to update the Content
            if(GxcContentPermission::checkUpdatePermission($param_content_check,$data_content_check,
                    $types[$type]['class']::Permissions())){
                
                    //Convert the object date from timestamp to datetime format
                    $model->object_date=date('Y-m-d H:i:s',$model->object_date);
                    
                    //Get available content Status that the Object can be sent to
                    $content_status=GxcContentPermission::getContentStatus($param_content_check,$data_content_check,
                        $types[$type]['class']::Permissions());
                    
                    //If the Object is Pending and being sent to someone, get that person info
                    if($model->object_status==ConstantDefine::OBJECT_STATUS_PENDING){
                            
                            if($latest_trans_to->type==ConstantDefine::TRANS_PERSON){
                                    $send_to_user=User::model()->findbyPk($latest_trans_to->to_user_id);
                                    if($send_to_user==null){
                                            $model->person='';
                                    } else {
                                            $model->person=trim($send_to_user->display_name);
                                    }
                            }
                    }
                    
                 
                    
                    //Unset value for Lang Exclude, Version and Guid when updating
                    $lang_exclude=array();
                    $versions=array();
                    $guid=$model->guid;
                    
                    
                    // Create new instance Object based on Object Type
                    $object = new $types[$type]['class'];
                    $object->person=$model->person;
                    $object->setAttributes($model->attributes,false);

                    // Get Extra Info - Object Meta of the Object Type
                    $object_metas = ObjectMeta::model()->findAll('meta_object_id = :obj ',
                                             array(':obj'=>$model->object_id));

                    foreach($object_metas as $object_meta){
				$key = (string)$object_meta->meta_key;
				$object->$key=$object_meta->meta_value;
                    }
                    
                    
                    // This is not a new Record                       
                    $object->isNewRecord=false;
                    
                    //Set current tags for Object
                    $object->_oldTags=$object->tags;
                  
                      
                    //Available Terms for this Object Type
                    $terms=array();  

                    //Selected Terms
                    $selected_terms=array();
                    
                    
                    //Get available Taxonomy and Terms for this Object
                    $available_taxonomy=Taxonomy::model()->findAll(' type = :type AND lang IN ('.$object->lang.') ',array(':type'=>$type,

                        ));                                               
                    if($available_taxonomy){
                        foreach($available_taxonomy as $t){
                            $temp=array();
                            $temp['id']=$t->taxonomy_id;
                            $temp['lang']=$t->lang;
                            $temp['name']=$t->name;
                            $temp['terms']=array();
                            
                            $selected_temp=array();
                            $selected_temp['id']=$t->taxonomy_id;
                            $selected_temp['lang']=$t->lang;
                            $selected_temp['name']=$t->name;
                            $selected_temp['terms']=array();


                            //Look for the Term Items belong to this Taxonomy
                            $list_terms=Term::model()->findAll(
                                     array(
                                         'select'=>'*',
                                         'condition'=>'taxonomy_id=:id',
                                         'order'=>'t.parent ASC, t.order ASC',
                                         'params'=>array(':id'=>$t->taxonomy_id)
                                     ));
                            if($list_terms){
                                foreach($list_terms as $term) {                
                                    $temp_item['id']=$term->term_id;
                                    $temp_item['name']=CHtml::encode($term->name);
                                    $temp_item['parent']=$term->parent;

                                    $temp['terms']['item_'.$term->term_id]=$temp_item;
                                }
                            }

                            $terms[$t->taxonomy_id]=$temp;  
                            
                            //Look for selected Terms belong to this Taxonomy
                            
                            $sl_terms=ObjectTerm::model()->findAll(
                                     array(
                                         'select'=>'*',
                                         'condition'=>'object_id=:id',                                         
                                         'params'=>array(':id'=>$object->object_id)
                                     ));
                            if($sl_terms){
                                foreach($sl_terms as $sl_term) {                
                                    if(isset($terms[$t->taxonomy_id]['terms']['item_'.$sl_term->term_id])){
                                        $selected_temp['terms']['item_'.$sl_term->term_id]=$terms[$t->taxonomy_id]['terms']['item_'.$sl_term->term_id];
                                    }
                                }
                            }

                            $selected_terms[$t->taxonomy_id]=$selected_temp;  


                        }
                    }
                  
                    //IF having the Post Method - Start to working to save it
                    if(isset($_POST[$types[$type]['class']]))                        
                    {
                            $object->attributes=$_POST[$types[$type]['class']];
                                                                                      
                            //Convert the date time publish to timestamp
                            $object->object_date=strtotime($object->object_date);
                            $object->object_date_gmt=local_to_gmt($object->object_date);

                            //Check which button the User click To Send to person or group
                            $button=$_POST['which_button'];
                            $trans=new Transfer;
                            
                            // Get the Terms that the User Choose                                                        
                            $post_terms=isset($_POST['terms']) ? $_POST['terms'] : array();                                                            
                            $selected_terms=array(); 
                            if(!empty($post_terms)){                                                             
                                    foreach($post_terms as $t){       
                                    $t=explode('_',$t);
                                    if(!isset($selected_terms[$t[1]])){
                                        $selected_temp=array();
                                        $selected_temp['id']=$terms[$t[1]]['id'];
                                        $selected_temp['lang']=$terms[$t[1]]['lang'];
                                        $selected_temp['name']=$terms[$t[1]]['name'];

                                        $selected_temp['terms']['item_'.$t[0]]['id']=$t[0];                                                                        
                                        $selected_temp['terms']['item_'.$t[0]]['name']=$terms[$t[1]]['terms']['item_'.$t[0]]['name'];
                                        $selected_temp['terms']['item_'.$t[0]]['parent']=$terms[$t[1]]['terms']['item_'.$t[0]]['parent'];

                                        $selected_terms[$t[1]]=$selected_temp;
                                    } else {
                                        if(!isset($selected_terms['terms']['item_'.$t[0]])){
                                            $selected_terms[$t[1]]['terms']['item_'.$t[0]]['id']=$t[0];                                                                        
                                            $selected_terms[$t[1]]['terms']['item_'.$t[0]]['name']=$terms[$t[1]]['terms']['item_'.$t[0]]['name'];
                                            $selected_terms[$t[1]]['terms']['item_'.$t[0]]['parent']=$terms[$t[1]]['terms']['item_'.$t[0]]['parent'];                                                                                        
                                        }
                                    }                                                                                                                                                
                                }
                            }
                            

                            // After having the selected Terms, we need to make sure  all parents
                            // of the selected Terms must be added also                                                               
                            foreach($selected_terms as $tx_key=>$t){                                    

                                $array_parent_selected_terms=array();   

                                foreach($t['terms'] as $key=>$st_terms){                                                                                                                      
                                    $current_term=$st_terms;
                                    while($current_term['parent']!=0){    

                                        if((!isset($array_parent_selected_terms['item_'.$current_term['parent']])) && ( 
                                               !isset($t['terms']['item_'.$current_term['parent']])
                                                )){
                                             $array_parent_selected_terms['item_'.$current_term['parent']]=$terms[$tx_key]['terms']['item_'.$current_term['parent']];
                                        }

                                        $current_term=$terms[$tx_key]['terms']['item_'.$current_term['parent']];

                                    }
                                }

                                $selected_terms[$tx_key]['terms']=CMap::mergeArray($t['terms'],$array_parent_selected_terms);

                            }  
                            //Re-Set the Status based on what User Chooose

                            //The content is sent to ROLES OR STATUS
                            if($button=='1'){

                                    //Check if the object_status is number or character
                                    if(!is_numeric($object->object_status)){
                                            //Set the status to Pending
                                            $trans->note=$object->object_status;
                                            $object->object_status=  ConstantDefine::OBJECT_STATUS_PENDING;
                                            $trans->type=  ConstantDefine::TRANS_ROLE;
                                            $trans->after_status=  ConstantDefine::OBJECT_STATUS_PENDING;

                                    } else {
                                            $trans->type=ConstantDefine::TRANS_STATUS;
                                            $trans->after_status=$object->object_status;
                                    }
                                    $trans->from_user_id=user()->id;
                                    $trans->to_user_id=0;
                                    $trans->before_status=  ConstantDefine::OBJECT_STATUS_DRAFT;


                            }

                            //The content is sent to PERSON DIRECTLY
                            if($button=='2'){

                                    $to_user_id= User::findPeople($object->person);

                                    //Start to Transfer to the user and set the status to Pending
                                    if($to_user_id){
                                        $object->object_status=  ConstantDefine::OBJECT_STATUS_PENDING;

                                        $trans->from_user_id=user()->id;
                                        $trans->to_user_id=$to_user_id->user_id;
                                        $trans->type=  ConstantDefine::TRANS_PERSON;
                                        $trans->before_status=  ConstantDefine::OBJECT_STATUS_PENDING;
                                        $trans->after_status=  ConstantDefine::OBJECT_STATUS_PENDING;
                                    } else {
                                            $object->addError('person',t('User not found'));
                                    }
                            }
                            
                             if($object->save()){          
                                        user()->setFlash('success',t('Update content Successfully!'));  
                                        $trans->object_id=$object->object_id;
                                        $trans->save();   
                                        
                                        //This is the update process, we should delete old
                                        //Object Term binding
                                        
                                        ObjectTerm::model()->deleteAll('object_id = :id',array(':id'=>$object->object_id));
                                        
                                        // We have all the selected Terms for now
                                        // We will add them to Object Terms
                                        foreach($selected_terms as $tx_key=>$t){                                                                                                                                                   
                                            foreach($t['terms'] as $key=>$st_terms){                                                                                                                                                
                                                $obj_term=new ObjectTerm();
                                                $obj_term->object_id=$object->object_id;
                                                $obj_term->term_id=$st_terms['id'];
                                                $obj_term->save();                                                                                               
                                                unset($obj_term);
                                            }
                                        }
                                        
                                        
                                        
                             }
                             $object->object_date=date('Y-m-d H:i:s',$object->object_date);
                             
                             
                    }
                    
                    //Start Render the Form 
                    $render_template='cmswidgets.views.object.object_form_widget';
                        
                    if(file_exists(Yii::getPathOfAlias('common.content_type.'.strtolower($type).'.object_form_widget').'.php')){
                        $render_template='common.content_type.'.strtolower($type).'.object_form_widget';
                    }
                    
                    
                    $this->render($render_template,
                            array('model'=>$object,
                                  'versions'=>$versions,
                                  'lang_exclude'=>$lang_exclude,
                                  'content_status'=>$content_status,
                                  'terms'=>$terms,
                                  'selected_terms'=>$selected_terms,
                                  'type'=>$type
                                ));                    
                    
            }
		                             
        
       
    }   
}
