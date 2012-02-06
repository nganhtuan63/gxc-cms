<div name="div-block-content-<?php echo $block_model->id;?>">
<div class="row">
	<?php echo CHtml::label(Block::getLabel($block_model,'html'),''); ?>
	<?php echo CHtml::textArea("Block[html]",
				    $block_model->html ,array('id'=>'Block-html',
                                    'rows'=>15, 'cols'=>50, 'style'=>'width:90%'
                         
                          )); ?>
	<?php echo $form->error($model,'html'); ?>

</div>
</div>
