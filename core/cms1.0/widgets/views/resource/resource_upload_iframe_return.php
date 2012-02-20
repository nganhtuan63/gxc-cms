<script type="text/javascript">
	window.parent.afterUploadResource('<?php echo $resource->resource_id; ?>','<?php 
	echo $resource->getFullPath()
?>','<?php echo $_GET['type']; ?>','<?php echo $resource->resource_type; ?>')
</script>
