<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="successMessage block-message alert-message success notification">
<div>
 <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
</div>
<script type="text/javascript" >
      $(".notification").delay(2100).fadeOut(1300);
</script>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):?>
<div class="errorMessage  block-message alert-message error notification">
<div>
 <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
</div>
<script type="text/javascript" >
      $(".notification").delay(2100).fadeOut(1300);
</script>
<?php endif; ?>