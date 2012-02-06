<?php

/**
 * This is the model class for table "{{user}}".
 * 
 * @author Tuan Nguyen
 * @version 1.0
 * @package cms.models.user
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $user_id
 * @property string $username
 * @property string $user_url
 * @property string $display_name
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $fbuid
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $recent_login
 * @property string $user_activation_key
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('salt,created_time, updated_time, recent_login, confirmed','safe'),
			array('username, display_name, email, password', 'required'),
                        
                        //Email must be Unique if it is on Create Scenairo
                        array('email', 'unique',
                        'attributeName'=>'email',
                        'className'=>'cms.models.user.User',
                        'message'=>t('This email has been registerd.'),
                        ),
                                                                   
                        //Email must be Unique if it is on Create Scenairo
                        array('username', 'unique',
                        'attributeName'=>'username',
                        'className'=>'cms.models.user.User',
                        'message'=>t('Username has been registerd.'),
                        ),     
                    
                        //Email must be Unique if it is on Create Scenairo
                        array('user_url', 'unique',
                        'attributeName'=>'user_url',
                        'className'=>'cms.models.user.User',
                        'message'=>t('Url has been registerd.'),
                        'allowEmpty'=>true
                        ),
                        
                        array('location', 'length', 'max'=>100),
                        array('bio', 'length', 'max'=>1500),
                        array('gender', 'in', 'range'=>array('male','female','other')),
                        array('birthday_month', 'in', 'range'=>array('january','febuary','march','april','may','june','july','august','september','october','november','december')),
                        array('birthday_day', 'numerical'),
                        array('birthday_year', 'numerical'),                    
			
                        array('status, created_time, updated_time, recent_login', 'numerical', 'integerOnly'=>true),
						array('username, user_url, password, salt, email', 'length', 'max'=>128),
						array('display_name', 'length', 'max'=>255),
						array('fbuid', 'length', 'max'=>20),
						array('user_activation_key', 'length', 'max'=>255),
						array('email_recover_key', 'length', 'max'=>255),                                               		
                        array('avatar', 'safe'), 
                        array('email_site_news','in','range'=>array('0','1')), 
                        array('email_search_alert','in','range'=>array('0','1')),
						// The following rule is used by search().
						// Please remove those attributes that should not be searched.
						array('user_id, username, user_url, display_name, email, fbuid, status, created_time, updated_time, recent_login', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => t('User'),
			'username' => t('Username'),
			'user_url' => t('User Url'),
			'display_name' => t('Display Name'),
			'password' => t('Password'),
			'salt' => t('Salt'),
			'email' => t('Email'),
			'fbuid' => t('Fbuid'),
			'status' => t('Status'),
			'created_time' => t('Created Time'),
			'updated_time' => t('Updated Time'),
			'recent_login' => t('Recent Login'),
			'user_activation_key' => t('User Activation Key'),
            'confirmed' => t('Confirmed'),
            'avatar' => t('Avatar'),
            'email_site_news' => t('Email site news'),
            'email_search_alert' => t('Email search alert')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('user_url',$this->user_url,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('fbuid',$this->fbuid,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('recent_login',$this->recent_login);

                $sort = new CSort;
                $sort->attributes = array(
                        'user_id',
                );
                $sort->defaultOrder = 'user_id DESC';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort
		));
	}
        
        /**
         * Validate password based on Password and Salt String
         * @param string $password
         * @param string $salt
         * @return string
         */
        public function validatePassword($password,$salt)
	{
		
		return $this->hashPassword($password,$salt)===$this->password;
	}
	
        /**
         * Return Md5 encrypt of the password
         *  
         * @param string $password
         * @param string $salt
         * @return string 
         */
	public function hashPassword($password,$salt)
	{
	       return md5($password.$salt);
	}
        
        /**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
                        $this->email=strtolower($this->email);
                        $this->username=strtolower($this->username);
                        $this->user_url=strtolower($this->user_url);
			if($this->isNewRecord)
			{				
				$this->created_time=$this->updated_time=$this->recent_login=time();		
				$this->password = $this->hashPassword($this->password,ConstantDefine::USER_SALT);
				$this->salt=ConstantDefine::USER_SALT;                                

			}
			else {
                                
				$this->updated_time=time();
                        }
                       
			return true;
		}
		else
			return false;
	}
        
        //Do Clear Session after Save
        protected function afterSave()
		{
			parent::afterSave();	                
	                //If this user updated his own settings, changed the session of him
	                if($this->user_id==user()->id){
	                    Yii::app()->getSession()->remove('current_user');
	                    Yii::app()->getSession()->add('current_user', $this);
	                }
		}
        
        /**
         * Delete information of the User with Afer Delete
         */
        protected function afterDelete()
        {
                parent::afterDelete();
		AuthAssignment::model()->deleteAll('userid = :uid',
                                               array(':uid'=>$this->user_id));
		

        }
        
        /**
         * Static Function retrun String Roles of the User
         * @param bigint $uid
         * @return string
         */
	public static function getStringRoles($uid=0)
	{
		$roles=Rights::getAssignedRoles($uid,true);
                $res=array();
		foreach($roles as $r){
			$res[]=$r->name;
		}
                if(count($res)>0)
                    return implode(",",$res);
                else 
                    return '';
		
	}
        
        /**
         * Return the String to the image
         * @param CActiveRecord $data
         * @return string
         */
        public static function convertUserState($data)
		{               
	                 $image= ($data->status==ConstantDefine::USER_STATUS_ACTIVE) ? 'active' : 'disabled';
			 return Yii::app()->controller->backend_asset.'/images/'.$image.'.png'; 
		}
        
        
         /**
         * Suggests a list of existing tags matching the specified keyword.
         * @param string the keyword to be matched
         * @param integer maximum number of tags to be returned
         * @return array list of matching tag names
         */
        public static function suggestPeople($keyword,$limit=20)
        {
                $users=User::model()->findAll(array(
                        'condition'=>'display_name LIKE :keyword',
                        'limit'=>$limit,
                        'params'=>array(
                                ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                        ),
                ));
                $names=array();
                foreach($users as $user){
                    $names[]=$user->display_name;
                    
                }
                       
                return $names;
        }
        
        /**
         * Find user with exactly display_name
         * @param type $keyword
         * @param type $limit
         * @return type 
         */
        public static function findPeople($keyword,$limit=20){            
            return User::model()->find(array(
                'condition'=>'display_name = :keyword',
                'limit'=>$limit,
                'params'=>array(
                        ':keyword'=>strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')),
                ),
                ));
        }

}