<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="notification notesuccess png_bg">
<div>
 <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
</div>
<script type="text/javascript" >
      $(".notification").delay(2100).fadeOut(1300);
</script>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):?>
<div class="notification noteerror png_bg">
<div>
 <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
</div>
<script type="text/javascript" >
      $(".notification").delay(2100).fadeOut(1300);
</script>
<?php endif; ?>