<?php

/**
 * Class Define Content Permission, Workflow for Object of the Core CMS
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.components
 */
class GxcContentPermission
{        
    
    public static function checkUpdatePermission($params=null,$data=null,$perm)
    {
        $roles=Rights::getAssignedRoles(user()->id,true);              
        
        $arr_result=array();
        foreach($roles as $role){
            if(array_key_exists (trim($role->name) , $perm)){              
                $arr_result[]=GxcContentPermission::execBizRules($perm[trim($role->name)]['allowedToUpdateContent'],$params,$data);
            }
        }
        if(in_array(true,$arr_result)){
            return true;
        } else {
            throw new CHttpException(403,t('You are not authorized to perform this action.'));
        }
    }
    
    public static function checkCreatePermission($params=null,$data=null,$perm)
    {
        $roles=Rights::getAssignedRoles(user()->id,true);        
        
        $arr_result=array();
        
        foreach($roles as $role){
            if(array_key_exists ( trim($role->name) , $perm)){                               
                $arr_result[]=$perm[trim($role->name)]['allowedToCreateContent'];              
            }
        }
        if(in_array(true,$arr_result)){
            return true;
        } else {
            throw new CHttpException(403,t('You are not authorized to perform this action.'));
        }
    }
    
    public static function getContentStatus($params=null,$data=null,$perm)
    {
        $roles=Rights::getAssignedRoles(user()->id,true);               
        $allow_transfer_list=array();
        $arr_result=array();
        foreach($roles as $role){
            if(array_key_exists (trim($role->name) , $perm)){
                $object_status=$perm[trim($role->name)]['allowedObjectStatus'];
                $transfer_list=$perm[trim($role->name)]['allowedTransferto'];
                foreach($object_status as $key=>$obj){                                      
                    if(GxcContentPermission::execBizRules($obj['condition'],$params,$data)){
                           $arr_result[]=$key;
                    }
                }
                foreach($transfer_list as $key_list=>$obj_list){
                    
                    if(GxcContentPermission::execBizRules($obj_list['condition'],$params,$data)){ 
                           $allow_transfer_list[$key_list]=$key_list;
                    }
                }
            }
        }
        
        $newResult=array();
        if(count($arr_result)>0){
            $arr_result=array_unique($arr_result);
                       
            foreach($arr_result as $res){
                $arr_content_status=ConstantDefine::getObjectStatus();
                $newResult[$res]=$arr_content_status[$res];
            }
            
          
            //Check if it has key Status Pending
            if(array_key_exists (ConstantDefine::OBJECT_STATUS_PENDING , $newResult)){
                //Remove the key which has status pending
                unset($newResult[ConstantDefine::OBJECT_STATUS_PENDING]);
                //Get the list of roles that can be transfered to
                foreach($transfer_list as $key_trans=>$obj_trans){
                     $newResult[$key_trans]=$key_trans;
                }
            }
        }
    
        
        return $newResult;
    }
    
    public static function execBizRules($bizRule,$params,$data)
    { 
	 return $bizRule==='' || $bizRule===null || eval($bizRule);
    }
    
    public static function checkTransferTo($params=null,$data=null,$perm)
    {	 
            $roles=Rights::getAssignedRoles(user()->id,true);            
            $arr_result=array();            
            $to_user_roles=Rights::getAssignedRoles($params['to_user_id'],true);
          
            foreach($roles as $role){
                if(array_key_exists ( trim($role->name) , $perm)){
                    foreach($to_user_roles as $to_role){
                        if(array_key_exists($to_role->name,$perm[trim($role->name)]['allowedTransferto'])){
                                $arr_result[]=GxcContentPermission::execBizRules($perm[trim($role->name)]['allowedTransferto'][$to_role->name]['condition'],$params,$data);
                        } else {
                                
                                $arr_result[]=false;
                        }
                    }
                }
            }
            if(in_array(true,$arr_result)){
                return true;
            } else {
                return false;
        }
         
    }
}

