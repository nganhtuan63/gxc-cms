<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
                'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'name'=>'CMS FRONT TEST ZONE',
		'components'=>array(
			'db'=>array(
                            'connectionString' => 'mysql:host=localhost;dbname=osgmain',
                            'emulatePrepare' => true,
                            'username' => 'root',
                            'password' => '',
                            'charset' => 'utf8',
                            'tablePrefix' => 'gxc_'
                        ),
                        'urlManager'=>array(
                            'urlFormat'=>'path',
                            'showScriptName' =>false,
                            'rules'=>array(
                                'item/<id:\d+>/<slug>'=>'object/view',
                                'page/<id:\d+>/<slug>'=>'site/view',    
                                '(cat/<cat:\d+>/<slug>)|(brand/<brand>)|(sale/<sale>)|(price/<price>)|(color/<color>)'=>'site/index',                                
                                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            ),
                        ),
		),
        'params'=>array(
            // this is used in contact page
            'site_url'=>'http://localhost/osg/frontend',
        ),
	)
);
