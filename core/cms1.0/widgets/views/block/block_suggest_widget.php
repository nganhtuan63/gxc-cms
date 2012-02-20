<p><?php echo t('Please select a Block: ');?></p>
<div class="form">  
<div class="row" id="changeBlocksWrapper">
        <div id="changeBlocks">
         <?php $this->widget('CAutoComplete', array(
                        'name'=>'changeBlockForm',                      
                        'url'=>array('suggestBlocks'),
                        'multiple'=>false,
                        'mustMatch'=>true,
                        'htmlOptions'=>array('size'=>50,'id'=>'change_block_form'),
                        'methodChain'=>".result(function(event,item){                                                            
                            if(item!==undefined) {           
                                \$('#block_title').val(item[0]);
                                \$('#block_id').val(item[1]);
                                
                            }


                        })",
                )); ?>
            <input type="hidden" id="block_title" value="" />
            <input type="hidden" id="block_id" value="" />
        <input type="button" class="button" value="<?php echo('Save'); ?>" onClick="addBlock(window.parent.document.getElementById('<?php echo $_GET['iframe_id']; ?>'));" />
        <input type="button" class="button" value="<?php echo('Cancel'); ?>" onClick="window.parent.cancelOnAddBlock(window.parent.document.getElementById('<?php echo $_GET['iframe_id']; ?>'));" />
        </div>
        <script type="text/javascript">
            
            function addBlock(object){
            	
                if($('#change_block_form').val()==''){
                    alert('<?php echo t('Please choose a block before adding!')?>');
                } else {
                    var title=$('#block_title').val();
                    var id=$('#block_id').val();
                    window.parent.updateOnAddBlock(object,title,id);
                }
            }
        </script>

    </div>
</div>    