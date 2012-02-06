<?php

return CMap::mergeArray(
	 require(COMMON_FOLDER.'/config.php'),
	array(
                'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'name' => 'BACKEND ZONE',
                'defaultController'=>'besite',
				'components'=>array(                                                
                        //Error Action when having Errors
                        'errorHandler'=>array(
                                // use 'site/error' action to display errors
                                'errorAction'=>'besite/error',
                        ),
                        
							'urlManager'=>array(
							'urlFormat'=>'path',
				                        'showScriptName' =>false,
										'rules'=>array(                                
											'<controller:\w+>/<id:\d+>'=>'<controller>/view',
											'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
											'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
										),
						),
						
                        //User Componenets                    
                        'user'=>array(
                                'class'=>'cms.components.user.GxcUser',
                                // enable cookie-based authentication
                                'allowAutoLogin'=>true,
                                'loginUrl'=>BACKEND_SITE_URL.'/besite/login',                        
                                'stateKeyPrefix'=>'gxc_system_user_',
                        ),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		),
	)
);
