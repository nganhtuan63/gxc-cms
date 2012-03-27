<p><?php echo t('Please choose a content type to continue'); ?></p>
<div>
<ul class="shortcut-buttons-set">
<?php foreach($types as $type) : ?>
<li>
<a href="<?php echo 'create/type/'.$type['id']; ?>" class="shortcut-button">
<span>
<img alt="icon" src="<?php 
if(YII_DEBUG)
$icon_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.content_type.'.$type['id'].'.assets'), false, -1, true);
else {
$icon_asset=Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.content_type.'.$type['id'].'.assets'), false, -1, false);	
}                    
echo $icon_asset.'/'.$type['icon']; ?>"><br />
<?php echo $type['name']?>
</span></a></li>
<?php endforeach; ?>
</ul>
</div>