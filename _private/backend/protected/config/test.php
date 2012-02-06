<?php

return CMap::mergeArray(
        require(dirname(__FILE__).'/main.php'),
	array(
                'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'name'=>'BACKEND TEST ZONE',
                'modules'=>array(
                            // uncomment the following to enable the Gii tool

                            'gii'=>array(
                                    'class'=>'system.gii.GiiModule',
                                    'password'=>'123456',
                                    // If removed, Gii defaults to localhost only. Edit carefully to taste.
                                    'ipFilters'=>array('127.0.0.1','::1'),
                            )

                    ),

		'components'=>array(
                    
			'db'=>array(
                            'connectionString' => 'mysql:host=localhost;dbname=hmn',
                            'emulatePrepare' => true,
                            'username' => 'root',
                            'password' => 'root',
                            'charset' => 'utf8',
                            'tablePrefix' => 'gxc_'
                        ),
                    
                        'urlManager'=>array(
                            'urlFormat'=>'path',
                            'showScriptName' =>true,
                            'rules'=>array(
                                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            ),
                        ),
                        
                    /*
                        //Log the Site Error, Warning and Store into File
                        'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                                array(
                                        'class'=>'CFileLogRoute',
                                        'levels'=>'error, warning',
                                ),
                                // uncomment the following to show log messages on web pages
                                                            
                                
                                array(
                                        'class'=>'CWebLogRoute',
                                ), 
                                  
                                  
        
                        ),
                         
                         
                        ),
                     * 
                     */
                        
		),
	)
);
