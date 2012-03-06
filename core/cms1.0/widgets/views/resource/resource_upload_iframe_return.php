<script type="text/javascript">
	<?php if(!isset($_GET['ckeditor'])) : ?>
	window.parent.afterUploadResource('<?php echo $resource->resource_id; ?>','<?php 
	echo $resource->getFullPath()
?>','<?php echo $_GET['type']; ?>','<?php echo $resource->resource_type; ?>')
	<?php else : ?>
	window.parent.afterUploadResourceWithEditor('<?php echo $resource->resource_id; ?>','<?php 
	echo $resource->getFullPath()
?>','<?php echo $resource->resource_type; ?>','<?php echo $_GET['ckeditor']?>','<?php echo isset($_POST['width']) ? (int)$_POST['width'] : "0" ?>',
<?php echo isset($_POST['height']) ? (int)$_POST['height'] : "0" ?>,'<?php echo isset($_POST['alt']) ? trim($_POST['alt']) : "" ?>')	
	<?php endif; ?>
</script>
