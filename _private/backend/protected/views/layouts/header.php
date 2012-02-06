<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<?php

        $cs=Yii::app()->clientScript;
        $cssCoreUrl = $cs->getCoreScriptUrl();
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');
        
        $cs->registerCssFile(bu().'/css/osg.css');

        //Publish Files from backend assets folders

        $urlScript =  $backend_asset.'/js/backend.js';
        $cs->registerScriptFile($urlScript, CClientScript::POS_HEAD);
   

?>
<!-- blueprint CSS framework -->
<link rel="stylesheet" type="text/css" href="<?php echo $backend_asset; ?>/css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="<?php echo $backend_asset; ?>/css/print.css" media="print" />
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo $backend_asset; ?>/css/ie.css" media="screen, projection" />
<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo $backend_asset; ?>/css/main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $backend_asset; ?>/css/form.css" />

<title><?php echo CHtml::encode($this->pageTitle); ?></title>
