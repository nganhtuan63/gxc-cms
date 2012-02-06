<?php

Yii::app()->setTimeZone(APP_TIMEZONE);
Yii::setPathOfAlias('common',COMMON_FOLDER);
Yii::setPathOfAlias('cms',CMS_FOLDER);
Yii::setPathOfAlias('frontend',FRONT_END);
Yii::setPathOfAlias('cmswidgets',CMS_WIDGETS);

return array(
	
	'name'=>'Học mỗi ngày',        
        'sourceLanguage'=>'en_us',
	// preloading 'log' component
	'preload'=>array('log','translate'),

	// autoloading model and component classes
        // autoloading from the CMS and Common Folder
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'cms.components.*',
                'cms.extensions.*',
                'cms.models.*',
                'cms.modules.*',
            
                //Import Specific CMS classes for CMS 
                'cms.components.user.*',
                'cms.models.user.*',
                'cms.models.settings.*',
                'cms.components.object.*',
                'cmswidgets.*',    
                'cmswidgets.object.*',                
                'cms.models.object.*',
                'cms.models.page.*',
            
                            
                'common.components.*',                                      
                'common.extensions.*',
                'common.models.*',
                'common.content_type.sale.*',                
                'common.modules.*',
                
                //Translate Module
                'cms.modules.translate.TranslateModule',
                'cms.modules.translate.controllers.*',
                'cms.modules.translate.models.*',
            
                //Import Rights Modules
                'cms.modules.rights.*',
                'cms.modules.rights.models.*',
                'cms.modules.rights.components.*',
                'cms.modules.rights.RightsModule',
            
                
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
                
                //Import Translate Module
                'translate'=>array(
                        'class'=>'cms.modules.translate.TranslateModule',
                ),
            
                //Modules Rights
                'rights'=>array(
                        'class'=>'cms.modules.rights.RightsModule',
                        'install'=>false,	// Enables the installer.
                        'appLayout'=>'application.views.layouts.main',
                        'superuserName'=>'Admin'

                    ),               
                    
	),

	// application components
	'components'=>array(
            
               
                //User Componenets
				'user'=>array(
		                        'class'=>'cms.components.user.GxcUser',
					// enable cookie-based authentication
					'allowAutoLogin'=>true,
		                        'loginUrl'=>FRONT_SITE_URL.'/sign-in',                        
		                        'stateKeyPrefix'=>'gxc_system_user_hmn',
				),
                
                //Auth Manager
                'authManager'=>array(
                        'class'=>'cms.modules.rights.components.RDbAuthManager',
                        'defaultRoles'=>array('Guest','Authenticated')
                ),
                    
                //Use Cache System by File
                'cache'=>array(
                    'class'=>'system.caching.CFileCache',
                ),
                
                //Use the Settings Extension and Store value in Database
                'settings'=>array(
                    'class'     => 'cms.extensions.settings.CmsSettings',
                    'cacheId'   => 'global_website_settings',
                    'cacheTime' => 84000,
                ),
                
			// URL Format and Rewrite
			
			'urlManager'=>array(
				'urlFormat'=>'path',
	                        'showScriptName' =>false,
				'rules'=>array(       
					                         
					//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),
            
		//Use MySQL database		
		'db'=>array(
                            'connectionString' => 'mysql:host=localhost;dbname=hmn',
                            'emulatePrepare' => true,
                            'username' => 'root',
                            'password' => 'root',
                            'charset' => 'utf8',
                            'tablePrefix' => 'gxc_'
                        ),
                
                //Use Session Handle in Database
                'session' => array(
                        'class' => 'CDbHttpSession',
                        'connectionID' => 'db',
                        'autoCreateSessionTable'=>true,
                        'sessionTableName'=>'gxc_session',
                ),
            

                //Error Action when having Errors
		'errorHandler'=>array(
			// use 'site/error' action to display errors
                        'errorAction'=>'site/error',
                ),
                
                //Log the Site Error, Warning and Store into File
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                
                // Use Message in Database and Translate Components
                'messages'=>array(
                    'class'=>'CDbMessageSource',
                    'sourceMessageTable'=>'gxc_source_message',
                    'translatedMessageTable'=>'gxc_translated_message',
                    'onMissingTranslation' => array('TranslateModule', 'missingTranslation'),
                ),
                
                'translate'=>array(
                    'class'=>'cms.modules.translate.components.MPTranslate',
                    //any avaliable options here
                    'acceptedLanguages'=>array(
                        'en_us'=>'English',
                        'vi_vn'=>'Tiếng Việt'                                                                           
                    ),
                    
                ),
                
                //Enable Cookie Validation and Csrf Validation
                'request'=>array(
                    'enableCookieValidation'=>true,
                    'enableCsrfValidation'=>true,
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
        // Don't use this, use the settings Components
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'support@hocmoingay.com',
	),
);