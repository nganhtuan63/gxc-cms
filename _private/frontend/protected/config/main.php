<?php

return CMap::mergeArray(
	require(COMMON_FOLDER.'/config.php'),
	array(
                'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'name' => 'OSG',
				'components'=>array(
					/* uncomment the following to provide test database connection
					'db'=>array(
						'connectionString'=>'DSN for test database',
					),
					*/
                        'urlManager'=>array(
                            'urlFormat'=>'path',
                            'showScriptName' =>false,                            
                            'rules'=>array(
                            	'<slug>'=>'site/index',
                              	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            ),
                        ),
		),
	)
);
