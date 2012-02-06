<?php

/**
 * Backend Osg Color Controller.
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @version 1.0
 * @package backend.controllers
 *
 */
class ObcolorController extends BeController{     
    
    public $defaultAction='admin';
        
    public function __construct($id,$module=null)
    {
         parent::__construct($id,$module);
                 $this->menu=array(
                        array('label'=>t('Manage Color'), 'url'=>array('admin'),'linkOptions'=>array('class'=>'button')),
                        array('label'=>t('Add Color'), 'url'=>array('create'),'linkOptions'=>array('class'=>'button')),
                );
         
    }
    
    
        /**
     * Displays a particular model.
     * @param integer $id the object_id of the model to be displayed
     */
    public function actionView($id)
    {
        
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionUpdateObject(){
        if (isset($_POST['item_selected']) && isset($_POST['color_selected'])) {
            $model = ObjectSale::model()->findByPk($_POST['item_selected']);
            if ($model) {
                $model->obj_color_id = $_POST['color_selected'];
                $model->save();
                $color_model = Color::model()->findByPk($model->obj_color_id);
                $arr = array("result"=>"1",
                             "color"=>$model->obj_color_id,
                             "H"=>$color_model->H,
                             "S"=>$color_model->S,
                             "L"=>$color_model->L,);
                echo json_encode($arr);//success
                return;
            }             
        }              
        echo json_encode(array("result"=>"0"));//failed
    }
    
    
    public function getBackground($image) {
        $yloop = 3;
        $bg = array();
        $height = imagesy($image);
        
        //get list of background colors from half of height border
        for ($y = 0; $y < $height/2; $y += $yloop) {
            $color = imagecolorat($image, 0, $y);
            $colorRGB = imagecolorsforindex($image,$color);
            $colorHSL = $this->getHSL($colorRGB);
            //if not exist in list
            if (array_search($colorHSL, $bg)===false) {
                $bg[] = $colorHSL; 
            }
        }
        return $bg;
    }
    
    public function compareBackground($bgColorArray, $color) {
        foreach ($bgColorArray as $bgColor) {
            $distance = $this->distance($bgColor, $color);
            if ($distance < 20)
                return true;
        }
        return false;
    }
    
    function getMatchColor($defaultColors, $colorHSL, $backgroundArray = null) {
        $minMatchValue = 1000;
        $matchColorID = -1;
        
        //if not background color or don't care bg  
        if ($backgroundArray==null || !$this->compareBackground($backgroundArray, $colorHSL)) {                                        
            if ($colorHSL['L']>=87.5)
                //echo 'White : '.$colorHSL['H'].','.$colorHSL['S'].','.$colorHSL['L'].'<a href="#" style="background:HSL('.$colorHSL['H'].','.$colorHSL['S'].'%,'.$colorHSL['L'].'%);text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br/>';
                return $this->getColorIdByName('White');          
            if ($colorHSL['L']<=12.5)
                return $this->getColorIdByName('Black');
            if ($colorHSL['L']>25&&$colorHSL['L']<75&&$colorHSL['S']>0&&$colorHSL['S']<12.5)
                return $this->getColorIdByName('Gray');
            if ($colorHSL['L']>=75&&$colorHSL['L']<87.5&&$colorHSL['S']>0&&$colorHSL['S']<12.5)
                return $this->getColorIdByName('Silver');
            
            foreach($defaultColors as $defaultColorID => $defaultColorValue){   
                $distanceColor = $this->distance($defaultColorValue, $colorHSL);
                if ($distanceColor<$minMatchValue) {
                    $minMatchValue = $distanceColor;
                    $matchColorID = $defaultColorID;
                }                        
            }
        }
        
        return $matchColorID;
    }
    
    public function actionTestColor() {
        echo '<form>Link: <input name="link" type="text" /><input type="submit" value="submit"/></form>';
        if (!isset($_GET['link']) || strlen($_GET['link'])<=0) {
            return;
        }
        
        // default HSL
        $defaultColors = $this->getDefaultColor();        
        
        //create image from link
        $image = $this->createImageFromLink($_GET['link']);
        
        if (!$image) {
            echo "Error while loading image";
            return;
        }
        
        $positions = $this->getPositionOfItem($image);
        
        //get list of background colors
        $backgroundArray = $this->getBackground($image);
        var_dump($backgroundArray);
        
        $xloop = 8;
        $yloop = 8;
        
        $maxX = imagesx($image);
        $maxY = imagesy($image);
        
        $colorsHSL = array();
        for ($y = 5; $y < $maxY; $y += $yloop) {
            for ($x = 5; $x < $maxX; $x += $xloop) {
        //for ($y = $positions['minY']; $y < $positions['maxY']; $y += $yloop) {
        //    for ($x = $positions['minX']; $x < $positions['maxX']; $x += $xloop) {
                $color = imagecolorat($image, $x, $y);
                $colorRGB = imagecolorsforindex($image,$color);
                $colorsHSL[] = $this->getHSL($colorRGB);
            }
        }
        
        foreach ($colorsHSL as $colorHSL) {                 
            $matchColorID = $this->getMatchColor($defaultColors, $colorHSL, $backgroundArray);
            if ($matchColorID > -1) {
                if (isset($result[$matchColorID]))
                    $result[$matchColorID]++;
                else
                    $result[$matchColorID] = 1;                                                
            }                 
        }
        arsort($result);
        
        /*
        apply rule
        rule number 1: 
        if pink
          if red 2 or 3 =>red
        */
        reset($result);
        $colorOfItem = key($result);
        $listColorsID = array_keys($result);
        $count = 0;
            
        $pinkID = $this->getColorIdByName('Pink');
        $redID = $this->getColorIdByName('Red');
        if ($pinkID !== false && $redID !== false && $pinkID == $colorOfItem) { //is pink 
            if ((isset($listColorsID[$count+1]) && $listColorsID[$count+1]==$redID)
                || (isset($listColorsID[$count+2]) && $listColorsID[$count+2]==$redID)) {
                    $colorOfItem = $redID;                                
            }                            
        }
        else {
            /*  
            if brown || orange
                if intimate =>
                    if first color=brown => second color
            */    
            $brownID = $this->getColorIdByName('Brown');
            $orangeID = $this->getColorIdByName('Orange');
            $pos = $count;
            if (   ($brownID!==false && $brownID == $colorOfItem)
                || ($orangeID!==false && $orangeID == $colorOfItem)
                ) {
                //check if intimate
                if (isset($listColorsID[$count+1]) && $listColorsID[$count+1]!=$brownID && $listColorsID[$count+1]!=$orangeID) {
                    $colorOfItem = $listColorsID[$count+1];                                
                    $pos = $count+1;
                } 
                elseif (isset($listColorsID[$count+2])){
                    $colorOfItem = $listColorsID[$count+2];                                
                    $pos = $count+2;
                }                            
                //if result = pink, verify if it's red
                if ($pinkID!==false && $redID !==false && $pinkID == $colorOfItem
                    && $pos>$count && ((isset($listColorsID[$pos+1]) && $listColorsID[$pos+1]==$redID)
                                    || (isset($listColorsID[$pos+2]) && $listColorsID[$pos+2]==$redID))
                    ) {
                        $colorOfItem = $redID;
                    }                                
            }                        
        } 
        
        echo 'Image is: <img src="'.$_GET['link'].'"/><br/>';                    
        
        $colorModel = Color::model()->findByPk($colorOfItem);
        if ($colorModel) {
            echo '<strong>Color ID of item:'.$colorOfItem.'</strong><br/>';
            echo 'Color Name of item:'.$colorModel->colorname.'<br/>';
            echo 'Color : <a href="#" style="background:HSL('.$colorModel->H.','.$colorModel->S.'%,'.$colorModel->L.'%);text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br/><br/>';
        }
            
        foreach ($result as $colorID => $count) {
            $colorModel = Color::model()->findByPk($colorID);
            if ($colorModel) {
                echo 'Color ID of item:'.$colorID.'<br/>';
                echo 'Color Name of item:'.$colorModel->colorname.'<br/>';
                echo 'Count:<strong>'.$count.'</strong><br/>';
                echo 'Color : <a href="#" style="background:HSL('.$colorModel->H.','.$colorModel->S.'%,'.$colorModel->L.'%);text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br/>';
            }
        }                        
    
    }
                             
    public function getColorIdByName($name){
        $model = Color::model()->findByAttributes(array('colorname'=>$name));
        if ($model)
            return $model->colorid;
        return false;
    }
    
    public function actionIndex()
    {   
        $dataProvider = new CActiveDataProvider('ObjectSale', array(
            'criteria'=>array(
                'with' => array('color'),
                'order'=>'obj_color_id ASC',                                                    
            ),
          
          'pagination'=>array(
                    'pageSize'=>'50'
                 ),      
        ));
        $this->render('index',array('dataProvider'=>$dataProvider));
        
    }
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Color;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Color']))
        {
            $model->attributes=$_POST['Color'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->colorid));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the object_id of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Color']))
        {
            $model->attributes=$_POST['Color'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->colorid));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
        
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the object_id of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    

    public function actionFetch()
    {
        $model = new Color;
        $this->render('fetch',array(
            'model'=>$model,
        ));
        
    }
    public function actionFetchColor(){
        $this->getColor();
        $this->actionIndex();
    }
    
    public function getDefaultColor(){
        $result = array();
        $defaultcolor = Color::model()->findAll();
        foreach ($defaultcolor as $item){
            $result[$item->colorid] = array(
                    'H'=>$item->H,
                    'S'=>$item->S,
                    'L'=>$item->L
                );
        }
        return $result;        
    }


    // Trims an image with position
    public function trimImage($positions, $image) {
        $imw = $positions['maxX']-$positions['minX'];
        $imh = $positions['maxY']-$positions['minY'];
        
        $im_processed = imagecreatetruecolor($imw, $imh);
        
        // Copy it over to the new image.
        imagecopy($im_processed, $image, 0, 0, $positions['minX'], $positions['minY'], $imw, $imh);
        imagejpeg($im_processed, 'outputY.jpg');
        imagedestroy($image);
        imagedestroy($im_processed);        
    }

    public function getColorOfImage($imageLink, $defaultColors, $isIntimate=false) {
        //create image from link
        $image = $this->createImageFromLink($imageLink);
        
        //get list of background colors
        $backgroundArray = $this->getBackground($image);
                
        $xloop = 8;
        $yloop = 8;
        
        $maxX = imagesx($image);
        $maxY = imagesy($image);
        
        $colorsHSL = array();
        for ($y = 5; $y < $maxY; $y += $yloop) {
            for ($x = 5; $x < $maxX; $x += $xloop) {
                $color = imagecolorat($image, $x, $y);
                $colorRGB = imagecolorsforindex($image,$color);
                $colorsHSL[] = $this->getHSL($colorRGB);
            }
        }
        
        foreach ($colorsHSL as $colorHSL) {                 
            $matchColorID = $this->getMatchColor($defaultColors, $colorHSL, $backgroundArray);
            if ($matchColorID > -1) {
                if (isset($result[$matchColorID]))
                    $result[$matchColorID]++;
                else
                    $result[$matchColorID] = 1;                                                
            }                 
        }
        arsort($result);
        
        /*
        apply rule
        rule number 1: 
        if pink
          if red 2 or 3 =>red
        */
        reset($result);
        $colorOfItem = key($result);
        $listColorsID = array_keys($result);
        $count = 0;
            
        $pinkID = $this->getColorIdByName('Pink');
        $redID = $this->getColorIdByName('Red');
        if ($pinkID !== false && $redID !== false && $pinkID == $colorOfItem) { //is pink 
            if ((isset($listColorsID[$count+1]) && $listColorsID[$count+1]==$redID)
                || (isset($listColorsID[$count+2]) && $listColorsID[$count+2]==$redID)) {
                    $colorOfItem = $redID;                                
            }                            
        }
        else {
            /*  
            if brown || orange
                if intimate =>
                    if first color=brown => second color
            */    
            $brownID = $this->getColorIdByName('Brown');
            $orangeID = $this->getColorIdByName('Orange');
            $pos = $count;
            //check if intimate            
            if ($isIntimate && (($brownID!==false && $brownID == $colorOfItem) || ($orangeID!==false && $orangeID == $colorOfItem))) {
                if (isset($listColorsID[$count+1]) && $listColorsID[$count+1]!=$brownID && $listColorsID[$count+1]!=$orangeID) {
                    $colorOfItem = $listColorsID[$count+1];                                
                    $pos = $count+1;
                } 
                elseif (isset($listColorsID[$count+2])){
                    $colorOfItem = $listColorsID[$count+2];                                
                    $pos = $count+2;
                }                            
                //if result = pink, verify if it's red
                if ($pinkID!==false && $redID !==false && $pinkID == $colorOfItem
                    && $pos>$count && ((isset($listColorsID[$pos+1]) && $listColorsID[$pos+1]==$redID)
                                    || (isset($listColorsID[$pos+2]) && $listColorsID[$pos+2]==$redID))
                    ) {
                        $colorOfItem = $redID;
                    }                                
            }                        
        } 
        return $colorOfItem;
    }
    
    public function actionResetColor(){
            ObjectSale::model()->updateAll(array('obj_color_id'=>''));
            $this->actionFetch();
        
    }
    
    public function isIntimate($intimates, $itemID) {
        foreach ($intimates as $intimate) {
            $objectTerm = ObjectTerm::model()->findByAttributes(array('object_id'=>$itemID, 'term_id'=>$intimate->term_id));
            if ($objectTerm!=null)
                return true;
        }                   
        return false;
    }
    
    public function getColor(){
        $items = ObjectSale::model()->findAllByAttributes(array('obj_color_id' => ''));
        
        // default HSL
        $defaultColors = $this->getDefaultColor();
        
        $intimates = Term::model()->findAllByAttributes(array('name'=>'Intimates'));
        
        foreach ($items as $item) {
            $isIntimate = $this->isIntimate($intimates, $item->object_id);
            if($item->obj_local_image!=''){
            	$item->obj_color_id = $this->getColorOfImage(IMAGES_FOLDER.DIRECTORY_SEPARATOR.OsgConstantDefine::IMAGE_ORIGINAL_FOLDER.DIRECTORY_SEPARATOR.$item->obj_local_image, $defaultColors, $isIntimate);	
            } else {
            	$item->obj_color_id = $this->getColorOfImage($item->obj_image, $defaultColors, $isIntimate);
            }
            
            $item->save(); 
        }            
    }
    
        
        
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Color('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Color']))
            $model->attributes=$_GET['Color'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the object_id of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Color::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='color-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
        
        
    function distance($color1,$color2){
        $H = abs($color1['H'] - $color2['H']);
        $S = abs($color1['S'] - $color2['S']);
        $L = abs($color1['L'] - $color2['L']);
        $distance = sqrt(pow($H, 2)+pow($S, 2)+pow($L, 2));
        return $distance;
    }

    function RGBtoXYZ($rgb) {
        // RGB values
        $red = $rgb['red'];
        $green = $rgb['green'];
        $blue = $rgb['blue'];
         
        // same values, from 0 to 1
        $_red = $red/255;
        $_green = $green/255;
        $_blue = $blue/255;
         
        // adjusting values
        if($_red>0.04045){
             $_red = ($_red+0.055)/1.055;
             $_red = pow($_red,2.4);
        }
        else{
             $_red = $_red/12.92;
        }
        if($_green>0.04045){
             $_green = ($_green+0.055)/1.055;
             $_green = pow($_green,2.4);     
        }
        else{
             $_green = $_green/12.92;
        }
        if($_blue>0.04045){
             $_blue = ($_blue+0.055)/1.055;
             $_blue = pow($_blue,2.4);     
        }
        else{
             $_blue = $_blue/12.92;
        }
         
        $_red *= 100;
        $_green *= 100;
        $_blue *= 100;
         
        // applying the matrix
        $x = $_red * 0.4124 + $_green * 0.3576 + $_blue * 0.1805;
        $y = $_red * 0.2126 + $_green * 0.7152 + $_blue * 0.0722;
        $z = $_red * 0.0193 + $_green * 0.1192 + $_blue * 0.9505;
         
        return array('X'=>$x,'Y'=>$y,'Z'=>$z);            
    }
        
    public function XYZtoLAB($xyz) {
        $_x = $xyz['X']/95.047;
        $_y = $xyz['Y']/100;
        $_z = $xyz['Z']/108.883;
         
        // adjusting the values
        if($_x>0.008856){
             $_x = pow($_x,1/3);
        }
        else{
             $_x = 7.787*$_x + 16/116;
        }
        if($_y>0.008856){
             $_y = pow($_y,1/3);
        }
        else{
             $_y = (7.787*$_y) + (16/116);
          //   echo $_y."<br>";
        }
        if($_z>0.008856){
             $_z = pow($_z,1/3);
        }
        else{
             $_z = 7.787*$_z + 16/116;
        }
         
        $l= 116*$_y -16;
        $a= 500*($_x-$_y);
        $b= 200*($_y-$_z);
        
        return array('l'=>$l,'a'=>$a,'b'=>$b);
    }
    
    function distanceLAB($lab1,$lab2){
         $c1 = sqrt($lab1['a']*$lab1['a']+$lab1['b']*$lab1['b']);
         $c2 = sqrt($lab2['a']*$lab2['a']+$lab2['b']*$lab2['b']);
         $dc = $c1-$c2;
         $dl = $lab1['l']-$lab2['l'];
         $da = $lab1['a']-$lab2['a'];
         $db = $lab1['b']-$lab2['b'];
         $dh = sqrt(($da*$da)+($db*$db)-($dc*$dc));
         $first = $dl;
         $second = $dc/(1+0.045*$c1);
         $third = $dh/(1+0.015*$c1);
         return(sqrt($first*$first+$second*$second+$third*$third));
    }
    
    function color_hsl2rgb($hsl) {
      $h = $hsl['H'];
      $s = $hsl['S'];
      $l = $hsl['L'];
      $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
      $m1 = $l * 2 - $m2;
      return array('red'=>$this->_color_hue2rgb($m1, $m2, $h + 0.33333),
                   'green'=>$this->_color_hue2rgb($m1, $m2, $h),
                   'blue'=>$this->_color_hue2rgb($m1, $m2, $h - 0.33333));
    }

    /**
     * Helper function for _color_hsl2rgb().
     */
    function _color_hue2rgb($m1, $m2, $h) {
      $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
      if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
      if ($h * 2 < 1) return $m2;
      if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
      return $m1;
    }
    /**
     *
     * @param type $rgb (value from 0 to 255)
     * @return type $array(H,S,L) (value H to 360,  S and L to 100)
     */
    function getHSL($rgb){
        $clrR = $rgb['red'];
        $clrG = $rgb['green'];
        $clrB = $rgb['blue'];

        $clrMin = min($clrR, $clrG, $clrB);
        $clrMax = max($clrR, $clrG, $clrB);
        $deltaMax = $clrMax - $clrMin;

        $L = ($clrMax + $clrMin) / 510;

        if (0 == $deltaMax){
            $H = 0;
            $S = 0;
        }
        else{
            if (0.5 > $L){
                $S = $deltaMax / ($clrMax + $clrMin);
            }
            else{
                $S = $deltaMax / (510 - $clrMax - $clrMin);
            }

            if ($clrMax == $clrR) {
                $H = ($clrG - $clrB) / (6.0 * $deltaMax);
            }
            else if ($clrMax == $clrG) {
                $H = 1/3 + ($clrB - $clrR) / (6.0 * $deltaMax);
            }
            else {
                $H = 2 / 3 + ($clrR - $clrG) / (6.0 * $deltaMax);
            }

            if (0 > $H) $H += 1;
            if (1 < $H) $H -= 1;
        }
    //    echo $H . '--' . $S . '--' . $L;
        $h = round($H * 360);
        $s = round($S * 100);
        $l = round($L * 100);
        return array('H'=>$h,'S'=>$s,'L'=>$l);
    }

    /**
     *
     * @param type $file
     * @return type 
     * get correct RGB color in each pixels
     */
        
    function createImageFromLink($imageLink) {
        try {
            $imageInfo = getImageSize($imageLink);
        }
        catch (Exception $e) {
            return null;
        }                

        switch ($imageInfo[2]) {
                case 1: //GIF
                        return imagecreatefromgif($imageLink);
                        break;
                case 2: //JPEG
                        return imagecreatefromjpeg($imageLink);
                        break;
                case 3: //PNG
                        return imagecreatefrompng($imageLink);
                        break;                    
        }
        return false;
    }
    
    function getColorsArrayOfItems($image) {
        $maxX = imagesx($image);
        $maxY = imagesx($image);
        //$step = 24;
        //$xloop = ceil( ( $maxX - 20 ) / ($steps - 1) );
        //$yloop = ceil( ( $maxY - 20 ) / ($steps - 1) );
        $xloop = 8;
        $yloop = 8;
        
        $colorsRGB = array();
        for ($y = 5; $y < $maxY; $y += $yloop) {
            for ($x = 5; $x < $maxX; $x += $xloop) {
                $color = imagecolorat($image, $x, $y);
                $colorsRGB[] = imagecolorsforindex($image,$color);
            }
        }
        
        $colorCount = 0;     
        foreach($colorsRGB as $color){
            if($colorCount == 0){
                $result['bg'] = $color;
            }
            if($colorCount == 216+12){
                $result['ct'] = $color;
            }
            
            if (($colorCount >= 48+6 && $colorCount <= 48+18) ||
                ($colorCount >= 72+6 && $colorCount <= 72+18) ||
                ($colorCount >= 96+6 && $colorCount <= 96+18) ||
                ($colorCount >= 120+6 && $colorCount <= 120+18) ||
                ($colorCount >= 144+6 && $colorCount <= 144+18) ||
                ($colorCount >= 168+6 && $colorCount <= 168+18) ||
                ($colorCount >= 192+6 && $colorCount <= 192+18) ||
                ($colorCount >= 216+6 && $colorCount <= 216+18) ||
                ($colorCount >= 240+6 && $colorCount <= 240+18) ||
                ($colorCount >= 264+6 && $colorCount <= 264+18) ||
                ($colorCount >= 288+6 && $colorCount <= 288+18) ||
                ($colorCount >= 312+6 && $colorCount <= 312+18) ||
                ($colorCount >= 336+6 && $colorCount <= 336+18) ||
                ($colorCount >= 360+6 && $colorCount <= 360+18) ||
                ($colorCount >= 384+6 && $colorCount <= 384+18) ||
                ($colorCount >= 408+6 && $colorCount <= 408+18) ||
                ($colorCount >= 432+6 && $colorCount <= 432+18) ||
                ($colorCount >= 456+6 && $colorCount <= 456+18) ||
                ($colorCount >= 480+6 && $colorCount <= 480+18)) {
                $result[] = $color;
            }
            $colorCount++;
        }
            
        return $result;
    }


    public function getPositionOfItem($starting_img) {
        $imw = imagesx($starting_img);
        $imh = imagesy($starting_img);
        
        $minX = 0;
        $minY = 0;
        $maxX = $imw;
        $maxY = $imh;
        for($x = 1; $x < $imw-1; $x++){
            for($y = 1; $y < $imh-1; $y++){
                // getting gray value of all surrounding pixels
                $pixel_up = $this->get_luminance(imagecolorat($starting_img,$x,$y-1));
                $pixel_down = $this->get_luminance(imagecolorat($starting_img,$x,$y+1)); 
                $pixel_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y));
                $pixel_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y));
                $pixel_up_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y-1));
                $pixel_up_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y-1));
                $pixel_down_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y+1));
                $pixel_down_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y+1));
         
                // appliying convolution mask
                $conv_x = ($pixel_up_right+($pixel_right*2)+$pixel_down_right)-($pixel_up_left+($pixel_left*2)+$pixel_down_left);
                $conv_y = ($pixel_up_left+($pixel_up*2)+$pixel_up_right)-($pixel_down_left+($pixel_down*2)+$pixel_down_right);
         
                // calculating the distance
                //$gray = sqrt($conv_x*$conv_x+$conv_y+$conv_y);
                $gray = abs($conv_x)+abs($conv_y);
         
                // inverting the distance not to get the negative image                
                $gray = 255-$gray;
         
                // if edge, assign new position
                if($gray <= 0){     
                    $minX = $minX===0 
                            ? $x
                            : min($x,$minX);               
                    $minY = $minY===0 
                            ? $y
                            : min($y,$minY);
                    $maxX = $maxX===$imw 
                            ? $x
                            : max($x,$maxX);               
                    $maxY = $maxY===$imh 
                            ? $y
                            : max($y,$maxY);                    
                }                
            }
        }
        return array('minX'=>$minX,'maxX'=>$maxX,'minY'=>$minY,'maxY'=>$maxY);
    }
    
    public function actionEdge() {
        // a butterfly image picked on flickr
        $source_image = "http://slimages.macys.com/is/image/MCY/products/7/optimized/995497_fpx.tif?bgc=255,255,255&wid=164&qlt=90,0&layer=comp&op_sharpen=0&resMode=bicub&op_usm=0.7,1.0,0.5,0&fmt=jpeg";
         
        // creating the image
        $starting_img = imagecreatefromjpeg($source_image);
         
        // getting image information (I need only width and height)
        $im_data = getimagesize($source_image);
         
        // this will be the final image, same width and height of the original
        $final = imagecreatetruecolor($im_data[0],$im_data[1]);
         
        // looping through ALL pixels!!
        for($x = 0; $x < $im_data[0]; $x++){
            for($y = 0; $y < $im_data[1]; $y++){
                if ($x==0 || $x==$im_data[0]-1
                 || $y==0 || $y==$im_data[1]-1) {
                    $new_gray  = imagecolorallocate($final,255,255,255);
                    imagesetpixel($final,$x,$y,$new_gray);                
                }
                else {
                    // getting gray value of all surrounding pixels
                    $pixel_up = $this->get_luminance(imagecolorat($starting_img,$x,$y-1));
                    $pixel_down = $this->get_luminance(imagecolorat($starting_img,$x,$y+1)); 
                    $pixel_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y));
                    $pixel_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y));
                    $pixel_up_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y-1));
                    $pixel_up_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y-1));
                    $pixel_down_left = $this->get_luminance(imagecolorat($starting_img,$x-1,$y+1));
                    $pixel_down_right = $this->get_luminance(imagecolorat($starting_img,$x+1,$y+1));
             
                    // appliying convolution mask
                    $conv_x = ($pixel_up_right+($pixel_right*2)+$pixel_down_right)-($pixel_up_left+($pixel_left*2)+$pixel_down_left);
                    $conv_y = ($pixel_up_left+($pixel_up*2)+$pixel_up_right)-($pixel_down_left+($pixel_down*2)+$pixel_down_right);
             
                    // calculating the distance
                    //$gray = sqrt($conv_x*$conv_x+$conv_y+$conv_y);
                    $gray = abs($conv_x)+abs($conv_y);
             
                    // inverting the distance not to get the negative image                
                    $gray = 255-$gray;
             
                    // adjusting distance if it's greater than 255 or less than zero (out of color range)
                    if($gray > 255){
                        $gray = 255;
                    }
                    if($gray < 0){
                        $gray = 0;
                    }
             
                    // creation of the new gray
                    if ($gray>0)
                        $new_gray  = imagecolorallocate($final,255,255,255);
                    else
                        $new_gray  = imagecolorallocate($final,$gray,$gray,$gray);
             
                    // adding the gray pixel to the new image                        
                    imagesetpixel($final,$x,$y,$new_gray);            
                }
            }
        }
         
        // telling the browser we are going to output a jpeg image
        header('Content-Type: image/jpeg');
         
        // creation of the final image
        imagejpeg($final,'edgetest3.jpg');
         
        // freeing memory
        imagedestroy($starting_img);
        imagedestroy($final);

    }
    
    // function to get the luminance value
    function get_luminance($pixel){
        $pixel = sprintf('%06x',$pixel);
        $red = hexdec(substr($pixel,0,2))*0.30;
        $green = hexdec(substr($pixel,2,2))*0.59;
        $blue = hexdec(substr($pixel,4))*0.11;
        return $red+$green+$blue;
    }    
}

?>
