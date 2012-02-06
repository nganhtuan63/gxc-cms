<?php

/**
 * Class to Identity User by Database Information.
 * 
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package cms.components.user
 */

class UserIdentityDb extends CUserIdentity{
              
	/**
         *
         * @var int Id of the User
         */
		private $_id;
        
        /**
         *
         * @var CActiveRecord current User Model
         */
        private $_model;
      
        
        /**
         * This function check the user Authentication 
         * 
         * @return int 
         */
        public function authenticate()
	{
	    $username=strtolower($this->username);
            
            if(strpos($username, '@')!==false){
                $user=User::model()->find('LOWER(email)=?',array($username));
            } else {
                $user=User::model()->find('LOWER(username)=?',array($username));
            }
	    
	    if($user===null){
		$this->errorCode=self::ERROR_USERNAME_INVALID;
                
            }
	    else if(!$user->validatePassword($this->password,$user->salt)){
		$this->errorCode=self::ERROR_PASSWORD_INVALID;
                
            }
	    else
	    {
                if($user->status==ConstantDefine::USER_STATUS_ACTIVE){
                    $this->_id=$user->user_id;          
                    
                    //If the site allow auto Login, create token to recheck for Cookies
                    if(Yii::app()->user->allowAutoLogin)
                    {
                        $autoLoginToken=sha1(uniqid(mt_rand(),true));
                        $this->setState('autoLoginToken',$autoLoginToken);
                        
                        $connection=Yii::app()->db;
                        
                        //delete old keys
                        $command=$connection->createCommand('DELETE FROM {{autologin_tokens}} WHERE user_id=:user_id');
                        $command->bindValue(':user_id',$user->user_id,PDO::PARAM_STR);
                        $command->execute();
                        
                        //set new
                        $command=$connection->createCommand('INSERT INTO {{autologin_tokens}}(user_id,token) VALUES(:user_id,:token)');
                        $command->bindValue(':user_id',$user->user_id,PDO::PARAM_STR);
                        $command->bindValue(':token',$autoLoginToken,PDO::PARAM_STR);
                        $command->execute();

                    }
                    
                    //Start to set the recent_login time for this user
                    $user->recent_login=time();
                    $user->save();
                    
                    $this->_model=$user;
                    
                    //Set the Error Code to None for Success
                    $this->errorCode=self::ERROR_NONE;	
                } else {
                    $this->errorCode=ConstantDefine::USER_ERROR_NOT_ACTIVE;
                }
	    }
            
            unset($user);
            
	    return $this->errorCode;
	}
        
        /**
         * Return the property _id of the class
         * @return bigint
         */
        public function getId()
	{
	    return $this->_id;
	}
           
        
        /**
         *
         * Return the _model of the class
         * @return CActiveRecord
         */
        public function getModel()
        {
            return $this->_model;
        }
}
?>
