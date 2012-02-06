<?php
$this->pageTitle=t('Update Brand');
$this->pageHint=t('Here you can update information for current Brand');  
?>

<?php if($process) : ?>
<?php echo $this->renderPartial('_form_brand', array('model'=>$model,'arr_fetch'=>$arr_fetch,'list_items'=>$list_items)); ?>
<?php else : ?>
<div class="form">
    <div class="errorSummary"><p>Please check these settings before going ahead:</p>
    <ul>
    <li>Disable Crawl.</li>
    <li>Disable Parse.</li>
    <li>Crawl Queue must be EMPTY.</li>
    <li>Parse Queue must be EMPTY.</li>
    </ul>
    </div>    
    <a href="javascript:history.go(-1)">Go Back</a> 
</div>
<?php endif; ?>