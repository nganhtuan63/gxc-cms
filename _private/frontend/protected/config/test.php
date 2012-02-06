<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
                'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'name'=>'OSG TEST ZONE',
				'components'=>array(
			
                        'urlManager'=>array(
                            'urlFormat'=>'path',
                            'showScriptName' =>false,
                            'rules'=>array(                                                     								
                               
                            ),
                        ),
                        'db'=>array(
                            'connectionString' => 'mysql:host=localhost;dbname=hmn',
                            'emulatePrepare' => true,
                            'username' => 'root',
                            'password' => 'root',
                            'charset' => 'utf8',
                            'tablePrefix' => 'gxc_'
                        ),
                                           
		),
	)
);
